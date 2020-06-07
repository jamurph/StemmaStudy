<?php

namespace App\Http\Controllers;

use App\Card;
use App\Set;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function show(Set $set,Card $card){
        $this->authorize('view-set', $set);
        return view('card.cardDetail', ['set' => $set, 'card' => $card]);
    }

    public function create(Set $set){
        $this->authorize('view-set', $set);
        return view('card.create', ['set'=> $set]);
    }

    public function store(Set $set, Request $request){
        $this->authorize('view-set', $set);
        $request->validate([
            'title' => ['required', 'min:3', 'max:100'],
            'definition' => ['required','max:500'],
        ]);
        $card = new Card([
            'title' => request('title'),
            'definition' => request('definition'),
            'set_id' => $set->id,
        ]);
        $card->save();

        return redirect()->route('user_card', [$set, $card]);
    }

    public function edit(Set $set, Card $card){
        $this->authorize('view-set', $set);
        return view('card.edit', ['set'=> $set, 'card' => $card]);
    }

    public function update(Set $set, Card $card, Request $request){
        $this->authorize('view-set', $set);
        $request->validate([
            'title' => ['required', 'min:3', 'max:100'],
            'definition' => ['required','max:500'],
        ]);
        $card->update([
            'title' => request('title'),
            'definition' => request('definition')
        ]);

        return redirect()->route('user_card', [$set, $card]);
    }

    public function destroy(Set $set, Card $card){
        $this->authorize('view-set', $set);

        $card->delete();

        return redirect()->route('cards_in_set', $set);
    }


}
