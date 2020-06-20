<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class Card extends Model
{
    Use HasTrixRichText;

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

    public function assessmentCards(){
        return $this->hasMany(AssessmentCard::class, 'card_id');
    }

    public function trixRender($field)
    {
        try {
            return $this->trixRichText->where('field', $field)->first()->content;
        } catch (Exception $e){
            //this shouldn't happen for Cards created by users (...right?). I added for my old test cards :D
            return $this->definition;
        }
    }
}
