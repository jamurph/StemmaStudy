<?php

namespace App\Http\Controllers;

use App\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function show(Card $card){
        $set = $card->set;
        $this->authorize('view-set', $set);
        return view('cardDetail', ['set' => $set, 'card' => $card]);
    }
}
