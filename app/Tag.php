<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    public function set(){
        return $this->belongsTo(Set::class);
    }

    public function cards(){
        return $this->belongsToMany(Card::class, 'card_tag');
    }
}
