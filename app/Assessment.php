<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'completed' => 'boolean',
    ];

    public function set(){
        return $this->belongsTo(Set::class);
    }

    public function assessmentCards(){
        return $this->hasMany(AssessmentCard::class, 'assessment_id');
    }

    public function assessmentCardScore($cardId){
        $assessmentCard = $this->assessmentCards->where('card_id', $cardId)->first();
        if($assessmentCard != null){
            return $assessmentCard->score;
        } else {
            return -1;
        }
    }
}
