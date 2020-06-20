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
        $request->validate([
            'title' => ['required', 'min:3', 'max:100'],
            'description' => ['max:500']
        ]);
        return ['updated' => $connection->update([
            'title' => request('title'),
            'description' => request('description') ?? '',
        ])];
    }

    public function store(Set $set, Request $request){
        $this->authorize('view-set', $set);
        $request->validate([
            'title' => ['required', 'min:3', 'max:100'],
            'description' => ['max:500']
        ]);
        $fromCardId = request('fromCardId');
        $toCardId = request('toCardId');

        $fromCardValid = Card::where('id', '=', $fromCardId)->where('set_id', '=', $set->id)->exists();
        $toCardValid = Card::where('id', '=', $toCardId)->where('set_id', '=', $set->id)->exists();

        if($fromCardValid && $toCardValid){
            $connection = new Connection([
                'title' => request('title'),
                'description' => request('description') ?? '',
                'from_card_id' => $fromCardId,
                'to_card_id' => $toCardId,
            ]);
            return ['created' => $connection->save()];
        } else {
            return ['created' => false];
        }
    }

    public function destroy(Set $set, Card $card, Connection $connection)
    {
        $this->authorize('view-set', $connection->fromCard->set);


        $connection->delete();

        return redirect()->route('user_card', [$set, $card]);
    }

}
