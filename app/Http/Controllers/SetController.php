<?php

namespace App\Http\Controllers;

use App\Card;
use App\Connection;
use App\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
        return view('set.cardsInSet', ['set' => $set]);
    }

    public function network(Set $set)
    {
        $this->authorize('view-set', $set);
        $connections = Connection::with(['fromCard'])->whereHas('fromCard', function($c) use ($set){
            $c->where('set_id', '=', $set->id);
        })->get();
        return view('set.setNetwork', ['set' => $set ,'cards' => $set->cards, 'connections' => $connections]);
    }

   

    public function create()
    {
        return view('set.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'min:3', 'max:100'],
            'description' => ['max:500'],
            //'public' => 'boolean',
        ]);
        $set = new Set([
            'title' => request('title'),
            'description' => request('description'),
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
            //'public' => 'boolean'
        ]);
        $set->update([
            'title' => request('title'),
            'description' => request('description'),
            //'public' => $request->has('public')
        ]);

        return redirect()->route('user_sets');
    }

    public function destroy(Set $set)
    {
        $this->authorize('view-set', $set);

        $set->delete();

        return redirect()->route('user_sets');
    }
}
