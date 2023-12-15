<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    protected $guarded = [];

    public function fromCard(){
        return $this->hasOne(Card::class, 'id', 'from_card_id');
    }

    public function toCard(){
        return $this->hasOne(Card::class, 'id','to_card_id');
    }
}
