<?php

namespace App\Http\Controllers;

use App\Assessment;
use App\AssessmentCard;
use Illuminate\Http\Request;
use App\Set;
use App\Card;
use Illuminate\Support\Carbon;

class ReviewController extends Controller
{
    public function review(Set $set)
    {
        $this->authorize('view-set', $set);
        $dueCount = $set->countDueCards();

        $unfinishedAssessment = $set->assessments->filter(function($value, $key){
            return !$value->completed;
        })->first();

        $assessments = $set->assessments->filter(function($value, $key){
            return $value->completed;
        });

        return view('review.review', ['set' => $set, 'due' => $dueCount, 'unfinishedAssessment' => $unfinishedAssessment, 'assessments' => $assessments]);
    }

    
    public function assessment_card(Set $set, Assessment $assessment, Request $request){
        if(!$request->user()->onTrialOrSubscribed()){
            return redirect()->route('set_review', $set);
        }
        $this->authorize('view-set', $set);
        //about 100% sure there's like 7 better ways to do all of this authorization...
        if($set->id != $assessment->set->id){
            return redirect()->route('user_sets');
        }

        if($set->cards->count() == 0){
            return redirect()->route('cards_in_set', $set);
        }

        //want a card we haven't done in this assessment yet.

        //get collection of card id's in this set
        $cardsInSet = $set->cards->pluck('id');

        //get collection of card id's we have seen in this assessment
        $assessed = $assessment->assessmentCards->pluck('card_id');

        //get the ones in set that have not been assessed.
        $candidates = $cardsInSet->diff($assessed);

        if($candidates->count() == 0){
            //complete assessment and set the average score.
            $assessment->completed = true;
            $assessment->score = $assessment->assessmentCards->pluck('score')->avg();
            $assessment->save();

            //route to finish page.
            return redirect()->route('assessment_complete', [$set, $assessment]);
        } else {
            //I mean...this shouldn't fail, right?? If you're from the future and this is a problem I am sorry.
            $chosenOne = Card::find($candidates->random());
            return view('review.assessmentCard', ['set' => $set, 'assessment' => $assessment, 'card' => $chosenOne ]);
        }
    }

    public function assessment_card_store(Request $request, Set $set, Assessment $assessment){
        if(!$request->user()->onTrialOrSubscribed()){
            return redirect()->route('set_review', $set);
        }
        $this->authorize('view-set', $set);
        $card_id = $request['card_id'];
        $score = $request['score'];

        $card = Card::findOrFail($card_id);
        if($set->id != $assessment->set->id || $set->id != $card->set->id){
            return redirect()->route('user_sets');
        }

        if($score < 0 || $score > 100){
            return redirect()->route('set_review', $set);
        }

        //prevent a resubmit of the same card
        $alreadyContains = $assessment->assessmentCards->contains(function($value, $key) use($card){
            return $value->card_id == $card->id;
        });
        if($alreadyContains){
            return redirect()->route('assessment_card', ['set'=> $set, 'assessment' => $assessment]);
        }

        //create new AssessmentCard
        $assessment_card = new AssessmentCard([
            'assessment_id' => $assessment->id,
            'card_id' => $card->id,
            'score' => $score
        ]);
        $assessment_card->save();

        return redirect()->route('assessment_card', ['set'=> $set, 'assessment' => $assessment]);
    }

    public function new_assessment(Set $set, Request $request){
        if(!$request->user()->onTrialOrSubscribed()){
            return redirect()->route('set_review', $set);
        }
        $this->authorize('view-set', $set);

        //any open assessments? Close. 
        $openAssessments = $set->assessments->filter(function($value, $key){
            return !$value->completed;
        });
        //ought to be just 1.
        foreach ($openAssessments as $assessment) {
            if($assessment->assessmentCards->count() == 0){
                $assessment->delete();
            }else {
                $assessment->completed = true;
                $assessment->score = $assessment->assessmentCards->pluck('score')->avg();
                $assessment->save();
            }
        }

        

        //create new!
        $new = new Assessment([
            'set_id' => $set->id
        ]);
        $new->save();

        return redirect()->route('assessment_card', ['set'=> $set, 'assessment' => $new]);
    }


    public function maintenance(Set $set){
        $this->authorize('view-set', $set);

        $now = Carbon::now();
        $reviewCards = $set->cards->filter(function($value, $key) use($now){
            return $value->next_review <= $now;
        });

        if ($reviewCards->count() > 0){
            $card = $reviewCards->random();
            return view('review.maintenance', ['set' => $set, 'card' => $card]);
        } else {
            return redirect()->route('set_review', [$set]);
        }
    }

    public function maintenance_put(Request $request, Set $set){

        $card_id = $request['card_id'];
        $score = $request['score'];

        if($score < 0 || $score > 100){
            return redirect()->route('set_maintenance', $set);
        }

        $card = Card::findOrFail($card_id);

        $this->authorize('view-set', $card->set);
        //don't allow an accidental resubmit (I.E. back button -> submit again)
        if($card->next_review > Carbon::now()){
            return redirect()->route('set_maintenance', $set);
        } else {

            //based on http://www.blueraja.com/blog/477/a-better-spaced-repetition-learning-algorithm-sm2
            //  implementing a slightly modified version of the original as described, rather than the modified
            
            //perhaps consider looking at https://www.supermemo.com/en/archives1990-2015/english/ol/sm2
            //or even other versions

            //consider correct if a score better than 70, than than 60 (corresponding to 3 in SM2) 
            $correct = $score > 70;

            // bound to [0, 5]
            $perfRating = ( $score / 100 ) * 5; 

            //old values
            $easiness = $card->easiness;
            $consecutive = $card->consecutive_correct;
            $next = $card->next_review;

            //easiness
            $easiness = $easiness + (-0.8 + 0.28 * $perfRating + 0.02 * ($perfRating * $perfRating));
            if($easiness < 1.3){
                $easiness = 1.3;
            }

            //consecutive correct and nextdue
            if($correct){
                $consecutive = $consecutive + 1;
                $daysToAdd = 6 * pow($easiness, $consecutive - 1);
                $next = Carbon::now()->addDays($daysToAdd)->subHour();
            } else {
                $consecutive = 0;
                $next = Carbon::now()->addDay()->subHour();
            }

            //set new values on card
            $card->easiness = $easiness;
            $card->consecutive_correct = $consecutive;
            $card->next_review = $next;

            $card->save();

            return redirect()->route('set_maintenance', $set);
        }
    }


}
