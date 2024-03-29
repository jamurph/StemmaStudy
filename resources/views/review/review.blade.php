@extends('layouts.app')

@section('title', 'StemmaStudy | Review')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <a class="text-decoration-none mb-3 d-inline-block" href="{{route('user_sets')}}"><i class="fas fa-arrow-left"></i> Back to My Sets</a>
            <h1 class="m-0 mb-2 break-word">Review: {{ $set->title }}</h1>
            <div class="mt-4"></div>
            @if ($set->cards->count() > 0)
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <div class="raised-box p-3 h-100 text-center">
                            <h3>Memory Maintenance</h3>
                            <img class="m-auto d-block" style="width:65%;" src="{{asset('/image/MaintainStrongMemories.png')}}" />
                            <p class="text-muted mt-2">Keep up-to-date and let the system optimize your review for the long-term.</p>
                            @if ($due == 0)
                                <p class=""><i class="fas fa-check green"></i> You are up to date!</p>
                            @else
                                <a class="btn btn-primary" href="{{route('set_maintenance', $set->id)}}">Begin Review</a>
                                <small><br>{{$due}} {{Str::plural('card', $due)}} due</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="raised-box p-3 h-100 text-center">
                            <h3>Assessment</h3>
                            <img class="m-auto d-block" style="width:65%;" src="{{asset('/image/ConcentrateYourEffort.png')}}" />
                            @if (!Auth::user()->onTrialOrSubscribed())
                            <div class="alert alert-info">
                                Your subscription has run out. <a href="{{route('subscribe')}}">Subscribe</a> to start new assessments.
                            </div>
                            @else
                                @if ($unfinishedAssessment != null)
                                <p class="text-muted mt-2">You have an unfinished assessment. Would you like to continue where you left off, or start over?</p>
                                @else
                                <p class="text-muted mt-2">Discover where your short-term weaknesses are and make more effective use of your study time.</p>
                                @endif
                                
                                <div class="">
                                    @if ($unfinishedAssessment != null)
                                        <a href="{{route('new_assessment', $set)}}" class="btn btn-secondary mr-3">Start Over</a>
                                        <a href="{{ route('assessment_card', ['set'=> $set, 'assessment' => $unfinishedAssessment]) }}" class="btn btn-primary ">Continue</a>
                                    @else
                                        <a href="{{route('new_assessment', $set)}}" class="btn btn-primary"><i class="fas fa-plus"></i> New</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="mt-4"></div>
                @if ($assessments->count() > 0)
                <h2>Completed Assessments</h2>
                <div class="table-responsive shadow-sm">
                    <table class="table table-striped past-assessments mb-0">
                        <thead>
                            <tr>
                            <th scope="col">Date</th>
                            <th scope="col"># Cards Assessed</th>
                            <th scope="col">Score</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assessments as $assessment)
                                <tr>
                                    <td>{{$assessment->created_at->toFormattedDateString()}}</td>
                                    <td>{{$assessment->assessmentCards->count()}}</td>
                                    <td>{{round( $assessment->score)}}%</td>
                                    <td class="text-right">
                                        <a class="text-decoration-none" href="{{route('assessment_network', [$set->id, $assessment->id])}}">View</a>
                                    </td>
                                    <td style="width: 15px;">
                                        <a class="unlink p-1" href="#" role="button" id="dropdownMenuLink{{$set->id}}" data-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu shadow">
                                        <a class="dropdown-item text-danger" href="{{route('assessment_destroy', [$set->id,$assessment->id])}}" onclick="event.preventDefault();deleteModal('#destroy-{{$assessment->id}}')">Delete</a>
                                                <form id="destroy-{{$assessment->id}}" method="POST" action="{{route('assessment_destroy', [$set->id, $assessment->id])}}" style="display: none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            @else 
            <div class="text-center raised-box p-3" style="">
                <h2>There's nothing to review yet!</h2>
                <p>Get started by adding your first card.</p>
                <a href="{{route('card_create', $set->id)}}" class="btn btn-primary"><i class="fas fa-plus"></i> New Card</a>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="reallyDelete" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Really Delete?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button id="deleteButton" type="button" class="btn btn-danger">Delete</button>
        </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function deleteModal(str){
        $('#deleteButton').off('click');
        $('#deleteButton').click(function(){
            $(str).submit();
        });
        $('.modal').modal();
    }
</script>
@endsection