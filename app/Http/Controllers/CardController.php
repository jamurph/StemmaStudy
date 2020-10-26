<?php

namespace App\Http\Controllers;

use App\Card;
use App\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Te7aHoudini\LaravelTrix\Models\TrixAttachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class CardController extends Controller
{

    public function show(Set $set,Card $card){
        $this->authorize('view-set', $card->set);

        //keep this, as adding connections refreshes the same page
        request()->session()->keep(['card_created']);

        return view('card.cardDetail', ['set' => $set, 'card' => $card]);
    }

    public function create(Set $set, Request $request){
        if(!$request->user()->onTrialOrSubscribed()){
            return redirect()->route('user_sets');
        }
        $this->authorize('view-set', $set);
        return view('card.create', ['set'=> $set]);
    }

    public function store(Set $set, Request $request){

        if(!$request->user()->onTrialOrSubscribed()){
            return redirect()->route('cards_in_set', $set);
        }
        $this->authorize('view-set', $set);

        //limit to 1000...
        if($set->cards->count() >= 1000){
            return redirect()->route('cards_in_set', $set);
        }

        $v = Validator::make($request->all(),[
            'title' => ['required', 'min:3', 'max:100'],
            'card-trixFields.content' => ['required', 'min:1', 'max:20000']
        ]);

        if($v->fails()){
            return redirect()->route('card_create', [$set])->withErrors($v);
        }

        //add target="_blank" to links.
        $content = str_replace('<a href=', '<a target="_blank" href=', request('card-trixFields.content'));

        //strip content of anything except what is allowed just in case... :)
        $stripped_content = strip_tags($content, ['div', 'ul', 'li', 'ol', 'strong', 'em', 'del', 'br', 'a', 'h1', 'blockquote', 'pre', 'figure', 'img', 'figcaption']);

        //strip links from preview, and truncate
        $preview = $this->truncateHtml(strip_tags($stripped_content, ['div', 'ul', 'li', 'ol', 'strong', 'em', 'del', 'br', 'h1', 'blockquote', 'pre', 'figure', 'img', 'figcaption']), 500);

        $card = new Card([
            'title' => request('title'),
            'definition' => $preview,
            'set_id' => $set->id,
            'next_review' => Carbon::now()->addDay()->subHour(),
            'card-trixFields' => ['content' => $stripped_content],
            'attachment-card-trixFields' => request('attachment-card-trixFields')
        ]);

        $position_y = DB::table('cards')->where('set_id', 1)->max('position_y');
        if($position_y && is_numeric($position_y)){
            $card->position_y = $position_y + 100;
        }
        $card->save();

        //to "add another card" from card detail
        session()->flash('card_created', true);
        
        return redirect()->route('user_card', [$set, $card]);
    }

    public function edit(Set $set, Card $card){
        $this->authorize('view-set', $card->set);
        return view('card.edit', ['set'=> $set, 'card' => $card]);
    }

    public function update(Set $set, Card $card, Request $request){
        $this->authorize('view-set', $card->set);

        $v = Validator::make($request->all(),[
            'title' => ['required', 'min:3', 'max:100'],
            'card-trixFields.content' => ['required', 'min:1', 'max:20000']
        ]);

        if($v->fails()){
            return redirect()->route('card_edit', [$set, $card])->withErrors($v);
        }

        //add target="_blank" to links.
        $content = str_replace('<a href=', '<a target="_blank" href=', request('card-trixFields.content'));

        //strip content of anything except what is allowed just in case... :)
        $stripped_content = strip_tags($content, ['div', 'ul', 'li', 'ol', 'strong', 'em', 'del', 'br', 'a', 'h1', 'blockquote', 'pre', 'figure', 'img', 'figcaption']);

        //strip links from preview, and truncate
        $preview = $this->truncateHtml(strip_tags($stripped_content, ['div', 'ul', 'li', 'ol', 'strong', 'em', 'del', 'br', 'h1', 'blockquote', 'pre', 'figure', 'img', 'figcaption']), 500);


        $card->update([
            'title' => request('title'),
            'definition' => $preview,
            'card-trixFields' => ['content' => $stripped_content],
            'attachment-card-trixFields' => request('attachment-card-trixFields')
        ]);

        return redirect()->route('user_card', [$set, $card]);
    }

    public function destroy(Set $set, Card $card){
        $this->authorize('view-set', $card->set);

        foreach($card->trixAttachments as $attachment){
            //removes from s3 and db
            $attachment->purge();
        }
        
        //will only be one
        foreach($card->trixRichText as $richText){
            $richText->delete();
        }
        $card->delete();
        
        if(session()->has('source') && session('source') == 'network'){
            return redirect()->route('set_network', $set);
        } else {
            return redirect()->route('cards_in_set', $set);
        }
    }

    
    

    public function get_attachment(Request $request, TrixAttachment $trixattachment){
        if(! $trixattachment->user_id == $request->user()->id){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $file = $trixattachment->attachment;

        if( ! Storage::exists($file)){
            return response()->json(['message' => 'Not Found'], 404);
        }

        return redirect(Storage::temporaryUrl(
            $file, now()->addMinutes(5)
        ));
    }

    
    public function store_attachment(Request $request){
        $validator = Validator::make($request->all(), [
            'key' => 'required',
            'modelClass' => 'required',
            'field' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if( ! Str::startsWith($request->get('key'), 'tmp') || ! Storage::exists($request->get('key'))){
            return response()->json(['errors'=> ['file' => ['File could not be saved.']]], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if( ! in_array(Storage::mimeType($request->get('key')), ['image/png', 'image/jpeg'])){
            return response()->json(['errors'=> ['file' => ['File must be a png or jpg image.']]], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $filepath = $request->get('key');
        
        $trixAttachment = TrixAttachment::create([
            'field' => $request->field,
            'attachable_type' => $request->modelClass,
            'attachment' => $filepath,
            'disk' => config('laravel-trix.storage_disk'),
            'user_id' => $request->user()->id,
            ]);
        
        $url = route('get_attachment', ['trixattachment'=>$trixAttachment->id]);

        return response()->json(['url' => $url, 'attachment' => $filepath], Response::HTTP_CREATED);
    }

    public function destroy_attachment(Request $request, TrixAttachment $attachment){
        if(!$request->user()->id === $attachment->user_id){
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $path = $attachment->attachment;

        /* 
         *  delete new images entirely. If they are editing, they may still hit cancel. 
         *  I am banking on the idea that edits are rare (and edits that remove images 
         *  must be strictly more so) to know that wasted storage would be low. 
         * 
         *  Some sort of job, or on-save check, could prevent this waste.
         */

        if(Str::startsWith($path, 'tmp/')){
            $attachment->purge();
        }

        return response()->json(['attachment' => $path]);
    }


    /**
     * truncateHtml can truncate a string up to a number of characters while preserving whole words and HTML tags
     * 
     * Source: https://alanwhipple.com/2011/05/25/php-truncate-string-preserving-html-tags-words/
     * 
     * 
     * @param string $text String to truncate.
     * @param integer $length Length of returned string, including ellipsis.
     * @param string $ending Ending to be appended to the trimmed string.
     * @param boolean $exact If false, $text will not be cut mid-word
     * @param boolean $considerHtml If true, HTML tags would be handled correctly
     *
     * @return string Trimmed string.
     */
    function truncateHtml($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true) {
        if ($considerHtml) {
            // if the plain text is shorter than the maximum length, return the whole text
            if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
                return $text;
            }
            // splits all html-tags to scanable lines
            preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
            $total_length = strlen($ending);
            $open_tags = array();
            $truncate = '';
            foreach ($lines as $line_matchings) {
                // if there is any html-tag in this line, handle it and add it (uncounted) to the output
                if (!empty($line_matchings[1])) {
                    // if it's an "empty element" with or without xhtml-conform closing slash
                    if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
                        // do nothing
                    // if tag is a closing tag
                    } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
                        // delete tag from $open_tags list
                        $pos = array_search($tag_matchings[1], $open_tags);
                        if ($pos !== false) {
                        unset($open_tags[$pos]);
                        }
                    // if tag is an opening tag
                    } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
                        // add tag to the beginning of $open_tags list
                        array_unshift($open_tags, strtolower($tag_matchings[1]));
                    }
                    // add html-tag to $truncate'd text
                    $truncate .= $line_matchings[1];
                }
                // calculate the length of the plain text part of the line; handle entities as one character
                $content_length = strlen(preg_replace('/&amp;[0-9a-z]{2,8};|&amp;#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
                if ($total_length+$content_length> $length) {
                    // the number of characters which are left
                    $left = $length - $total_length;
                    $entities_length = 0;
                    // search for html entities
                    if (preg_match_all('/&amp;[0-9a-z]{2,8};|&amp;#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
                        // calculate the real length of all entities in the legal range
                        foreach ($entities[0] as $entity) {
                            if ($entity[1]+1-$entities_length <= $left) {
                                $left--;
                                $entities_length += strlen($entity[0]);
                            } else {
                                // no more characters left
                                break;
                            }
                        }
                    }
                    $truncate .= substr($line_matchings[2], 0, $left+$entities_length);
                    // maximum lenght is reached, so get off the loop
                    break;
                } else {
                    $truncate .= $line_matchings[2];
                    $total_length += $content_length;
                }
                // if the maximum length is reached, get off the loop
                if($total_length>= $length) {
                    break;
                }
            }
        } else {
            if (strlen($text) <= $length) {
                return $text;
            } else {
                $truncate = substr($text, 0, $length - strlen($ending));
            }
        }
        // if the words shouldn't be cut in the middle...
        if (!$exact) {
            // ...search the last occurance of a space...
            $spacepos = strrpos($truncate, ' ');
            if (isset($spacepos)) {
                // ...and cut the text in this position
                $truncate = substr($truncate, 0, $spacepos);
            }
        }
        // add the defined ending to the text
        $truncate .= $ending;
        if($considerHtml) {
            // close all unclosed html-tags
            foreach ($open_tags as $tag) {
                $truncate .= '</' . $tag . '>';
            }
        }
        return $truncate;
    }



}
