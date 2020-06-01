<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    protected $guarded = [];

    public function set(){
        return $this->belongsTo(Set::class);
    }

    public function connectionsIn(){
        return $this->hasMany(Connection::class, 'to_card_id');
    }

    public function connectionsOut(){
        return $this->hasMany(Connection::class, 'from_card_id');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'card_tag');
    }
}
