<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function show(Request $request){
        $onTrial = $request->user()->onTrial();
        $subscription = $request->user()->subscription('default');
        $subscribed = $subscription == null ? false : !$subscription->ended();
        $trialEnd = $request->user()->trial_ends_at == null ? now()->toFormattedDateString() : $request->user()->trial_ends_at->toFormattedDateString();
        return view('settings.show', ['user' => $request->user(), 'freeTrial' => $onTrial, 'trialEnd' => $trialEnd, 'subscribed' => $subscribed]);
    }

    public function updateName(Request $request){
        $request->validate([
            'username' => ['required', 'string', 'max:50', 'min:3']
        ]);

        $user = $request->user();
        if($user->name == request('username')){
            return redirect()->route('settings')->withErrors(['username' => 'The new name must be different from your current account name.']);
        }

        $user->name = request('username');
        $user->save();
        
        return redirect()->route('settings')->with('updatedName', true);
    }

    public function portal(Request $request){
        return $request->user()->redirectToBillingPortal(route('user_sets'));
    }

    public function subscribe(Request $request){
        //verify that the user can actually subscribe, or redirect back to settings. (Something weird...?)
        return view('settings.subscribe', ['intent' => $request->user()->createSetupIntent()]);
    }
}
