<?php

namespace App\Http\Controllers;

use App\Card;
use App\Connection;
use App\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class for handling of viewing/editing sets owned by the user. "My Sets" 
 */
class SetController extends Controller
{

    public function index()
    {
        $sets = auth()->user()->sets;

        return view('set.sets', ['sets' => $sets,]);
    }

    public function show(Set $set)
    {
        $this->authorize('view-set', $set);

        //so we will redirect back to list from a card
        session()->put('source', 'list');

        return view('set.cardsInSet', ['set' => $set]);
    }

    public function create(Request $request)
    {
        if(!$request->user()->onTrialOrSubscribed()){
            return redirect()->route('user_sets');
        }
        return view('set.create');
    }

    public function store(Request $request)
    {
        if(!$request->user()->onTrialOrSubscribed()){
            return redirect()->route('user_sets');
        }

        $request->validate([
            'title' => ['required', 'min:3', 'max:100'],
            'description' => ['max:500'],
            'notify' => 'boolean',
            //'public' => 'boolean',
        ]);
        $set = new Set([
            'title' => request('title'),
            'description' => request('description'),
            'notify' => $request->has('notify'),
            'public' => false, // UNIMPLEMENTED
            'user_id' => auth()->user()->id,
        ]);
        $set->save();

        return redirect()->route('user_sets');
    }

    public function edit(Set $set)
    {
        $this->authorize('view-set', $set);
        return view('set.edit', ['set' => $set]);
    }

    public function update(Request $request, Set $set)
    {
        $this->authorize('view-set', $set);
        $request->validate([
            'title' => ['required', 'min:3', 'max:100'],
            'description' => ['max:500'],
            'notify' => 'boolean',
            //'public' => 'boolean'
        ]);
        $set->update([
            'title' => request('title'),
            'description' => request('description'),
            'notify' => $request->has('notify'),
            //'public' => $request->has('public')
        ]);

        return redirect()->route('user_sets');
    }

    public function destroy(Set $set)
    {
        $this->authorize('view-set', $set);

        //remove trix text and attachments associated with each card, as they do not cascade in db.
        foreach($set->cards as $card){
            foreach($card->trixAttachments as $attachment){
                //removes from s3 and db
                $attachment->purge();
            }
            
            //will only be one
            foreach($card->trixRichText as $richText){
                $richText->delete();
            }
        }

        $set->delete();

        return redirect()->route('user_sets');
    }

    public function network(Set $set)
    {
        $this->authorize('view-set', $set);
        $connections = Connection::with(['fromCard'])->whereHas('fromCard', function($c) use ($set){
            $c->where('set_id', '=', $set->id);
        })->get();

        //so we will redirect back to network from a card
        session()->put('source', 'network');

        return view('set.setNetwork', ['set' => $set ,'cards' => $set->cards, 'connections' => $connections]);
    }

    public function update_network(Set $set, Request $request){
        $this->authorize('view-set', $set);
        //get JSON. 
        $changes = $request->input('changes');
        if(!$changes){
            return false;
        }
        DB::transaction(function() use ($set, $changes){

            foreach ($changes as $change) {
                $card_id = $change['card_id'];
                $position_x = $change['position']['x'];
                $position_y = $change['position']['y'];
                
                $card = Card::find($card_id);
                if($card && $card->set_id == $set->id && is_numeric($position_x) && is_numeric($position_y)){
                    $card->position_x = $position_x + 0;
                    $card->position_y = $position_y + 0;
                    $card->is_new = false;
                    $card->save();
                }
            }
        });

        return true;
    }
}
