<?php

namespace App\Http\Controllers;

use App\Set;
use App\Card;
use App\Connection;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    
    public function update(Set $set, Connection $connection, Request $request){
        $this->authorize('view-set', $connection->fromCard->set);

        //keep this, as adding connections refreshes the same page
        $request->session()->keep(['card_created']);

        $request->validate([
            'title' => ['required', 'min:1', 'max:100'],
            'description' => ['max:500']
        ]);
        return ['updated' => $connection->update([
            'title' => request('title'),
            'description' => request('description') ?? '',
        ])];
    }

    public function store(Set $set, Request $request){
        if(!$request->user()->onTrialOrSubscribed()){
            return redirect()->route('cards_in_set', $set);
        }
        $this->authorize('view-set', $set);
        //keep this, as adding connections refreshes the same page
        $request->session()->keep(['card_created']);
        $request->validate([
            'title' => ['required', 'min:1', 'max:100'],
            'description' => ['max:500']
        ]);
        $fromCardId = request('fromCardId');
        $toCardId = request('toCardId');

        $fromCard = Card::where('id', '=', $fromCardId)->where('set_id', '=', $set->id)->first();
        $toCard = Card::where('id', '=', $toCardId)->where('set_id', '=', $set->id)->first();

        if($fromCard && $toCard){
            $connection = new Connection([
                'title' => request('title'),
                'description' => request('description') ?? '',
                'from_card_id' => $fromCardId,
                'to_card_id' => $toCardId,
            ]);

            //If one of the cards is new, put it on top of the other to help with the layout the next time the network view loads.
            if($fromCard->is_new && !$toCard->is_new){
                $fromCard->position_x = $toCard->position_x;
                $fromCard->position_y = $toCard->position_y;
                $fromCard->save();
            } else if (!$fromCard->is_new && $toCard->is_new){
                $toCard->position_x = $fromCard->position_x;
                $toCard->position_y = $fromCard->position_y;
                $toCard->save();
            }
            
            return ['created' => $connection->save(), 'id' => $connection->id];
        } else {
            return ['created' => false];
        }
    }

    public function destroy(Set $set, Card $card, Connection $connection)
    {
        $this->authorize('view-set', $connection->fromCard->set);

        //keep this, as adding connections refreshes the same page
        request()->session()->keep(['card_created']);

        $connection->delete();

        return redirect()->route('user_card', [$set, $card]);
    }

    public function destroy_async(Set $set, Connection $connection){
        $this->authorize('view-set', $connection->fromCard->set);

        return ['deleted' => $connection->delete()];
    }

}
