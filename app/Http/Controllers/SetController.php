<?php

namespace App\Http\Controllers;

use App\Connection;
use App\Set;
use Illuminate\Http\Request;

/**
 * Class for handling of viewing/editing sets owned by the user. "My Sets" 
 */
class SetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //sets retrieved from user in blade.
        return view('set.sets');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('set.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'min:3', 'max:100'],
            'description' => ['max:500'],
            'public' => 'boolean',
        ]);
        $set = new Set([
            'title' => request('title'),
            'description' => request('description'),
            'public' => $request->has('public'),
            'user_id' => auth()->user()->id,
        ]);
        $set->save();

        return redirect()->route('user_sets');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Set  $set
     * @return \Illuminate\Http\Response
     */
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
        return view('set.setNetwork', ['cards' => $set->cards, 'connections' => $connections]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Set  $set
     * @return \Illuminate\Http\Response
     */
    public function edit(Set $set)
    {
        $this->authorize('view-set', $set);
        return view('set.edit', ['set' => $set]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Set  $set
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Set $set)
    {
        $this->authorize('view-set', $set);
        $request->validate([
            'title' => ['required', 'min:3', 'max:100'],
            'description' => ['max:500'],
            'public' => 'boolean'
        ]);
        $set->update([
            'title' => request('title'),
            'description' => request('description'),
            'public' => $request->has('public')
        ]);

        return redirect()->route('user_sets');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Set  $set
     * @return \Illuminate\Http\Response
     */
    public function destroy(Set $set)
    {
        $this->authorize('view-set', $set);

        $set->delete();

        return redirect()->route('user_sets');
    }
}
