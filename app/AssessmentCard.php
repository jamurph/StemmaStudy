<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessmentCard extends Model
{
    protected $guarded = [];

    public function assessment(){
        return $this->belongsTo(Assessment::class);
    }

    public function card(){
        return $this->belongsTo(Card::class);
    }
}
