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
        // if the attachment is pending, we trust that this user is the one who created it, as the file name is generated (thus virtually unguessable in short term).
        $can_view = false;
        if( $trixattachment->is_pending ){
            $can_view = true;
        }else {
            $card = Card::where('id', $trixattachment->attachable_id)->first();
            if($card && $card->set->user->id === $request->user()->id){
                $can_view = true;
            }
        }

        if( !$can_view ){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $file = '';

        if(App::environment('local')){
            $file = '/public/';
        }

        $file = $file . $trixattachment->attachment;

        return response()->stream(function() use($file) {
            $stream = Storage::readStream($file);
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, 200, [
            "Content-Type" => Storage::mimeType($file),
            "Content-Length" => Storage::size($file),
            "Content-disposition" => "inline; filename=\"" . basename($file). "\"",
        ]); 
    }

    
    public function store_attachment(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimetypes:image/jpeg,image/png',
            'modelClass' => 'required',
            'field' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $file = $request->file('file');

        $resized = Image::make($file)->widen(1280, function($constraint){
            $constraint->upsize();
        })->encode();

        //file still too large after resizing. must be less than 1MB
        if($resized->filesize() > 1000000){
            return response()->json(['errors'=> ['file' => ['File size too large.']]], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $filename = uniqid() . '_' . $file->getClientOriginalName();
        $attached = Storage::disk($request->disk ?? config('laravel-trix.storage_disk'))->put($filename, (string)$resized);
        
        if( !$attached ){
            return response()->json(['errors'=> ['file' => ['File upload failed.']]], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        
        $trixAttachment = TrixAttachment::create([
            'field' => $request->field,
            'attachable_type' => $request->modelClass,
            'attachment' => $filename,
            'disk' => $request->disk ?? config('laravel-trix.storage_disk'),
            ]);
        
        $url = route('get_attachment', ['trixattachment'=>$trixAttachment->attachment]);

        return response()->json(['url' => $url], Response::HTTP_CREATED);
    }

    public function destroy_attachment($url){
        $attachment = TrixAttachment::where('attachment', basename($url))->first();

        //if it is pending, then we can delete it, as the user is on the same screen as it was uploaded. 
        //Otherwise, we simply hold on to it until the card is deleted. 
        //this may be revisited in the future, but as it stands this doesn't seem like this should be a big deal, storage-wise, as
        //  1. Edits to cards ought be rare as is, but edits that also change the image ought be even less prevalent
        //  2. Deleting cards will remove all the attachments
        //  3. The functionality for laravel-trix can be overridden
        //  4. A fix could be implemented to scrape for urls present in attachments but not trix rich texts and remove them.
        if($attachment->is_pending){
            return response()->json(optional($attachment)->purge());
        } else {
            return response()->json(optional($attachment));
        }
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
