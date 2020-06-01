<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function cards(){
        return $this->hasMany(Card::class);
    }

    public function tags(){
        return $this->hasMany(Tag::class);
    }

}
