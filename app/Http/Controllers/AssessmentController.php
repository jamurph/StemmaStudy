<?php

namespace App\Http\Controllers;

use App\Assessment;
use App\Set;
use App\Connection;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{

    public function show(Set $set, Assessment $assessment){
        $set = $assessment->set;
        
        $this->authorize('view-set', $set);

        return view('review.assessmentComplete', ['assessment' => $assessment]);
    }

    public function network(Set $set, Assessment $assessment){
        $this->authorize('view-set', $set);
        //about 100% sure there's like 7 better ways to do all of this authorization...
        if($set->id != $assessment->set->id){
            return redirect()->route('user_sets');
        }

        if(!$assessment->completed){
            return redirect()->route('assessment_card', [$set, $assessment]);
        }

        //connections belonging to cards in this set
        $connections = Connection::with(['fromCard'])->whereHas('fromCard', function($c) use ($set){
            $c->where('set_id', '=', $set->id);
        })->get();

        return view('review.assessmentNetwork', ['set' => $set, 'assessment' => $assessment, 'connections' => $connections]);
    }

    public function destroy(Set $set, Assessment $assessment)
    {
        $set = $assessment->set;
        
        $this->authorize('view-set', $set);

        $assessment->delete();

        return redirect()->route('set_review', ['set' => $set]);
    }
}
