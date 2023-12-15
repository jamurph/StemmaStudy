<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Set extends Model
{

    protected $guarded = [];

    protected $casts = [
        'public' => 'boolean',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function cards(){
        return $this->hasMany(Card::class);
    }

    public function tags(){
        return $this->hasMany(Tag::class);
    }

    public function assessments(){
        return $this->hasMany(Assessment::class, 'set_id');
    }

    public function countDueCards(){
        $today = Carbon::now();
        return $this->cards->filter(function($value, $key) use($today){
            return $value->next_review <= $today;
        })->count();
    }

}
