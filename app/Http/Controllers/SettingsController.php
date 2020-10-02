<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Illuminate\Support\Carbon;
use Newsletter;

class SettingsController extends Controller
{
    public function show(Request $request){

        $receives_emails = Newsletter::isSubscribed($request->user()->email);

        $subscription = $request->user()->subscription('default');
        $subscribed = $subscription == null ? false : !$subscription->ended();
        $onTrial = $request->user()->onGenericTrial() && !$subscribed; //onGenericTrial and Stripe "trialing" may coincide
        $trialEnd = $request->user()->trial_ends_at == null ? now()->toFormattedDateString() : $request->user()->trial_ends_at->toFormattedDateString();
        return view('settings.show', ['user' => $request->user(), 'freeTrial' => $onTrial, 'trialEnd' => $trialEnd, 'subscribed' => $subscribed, 'receives_emails' => $receives_emails]);
    }

    public function email_unsubscribe(Request $request){
        if(Newsletter::isSubscribed($request->user()->email)){
            Newsletter::unsubscribe($request->user()->email);
        }
        return true;
    }

    public function email_subscribe(Request $request){
        if(! Newsletter::isSubscribed($request->user()->email)){
            Newsletter::subscribeOrUpdate($request->user()->email);
        }
        return true;
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
        $subscription = $request->user()->subscription('default');
        if($subscription != null && !$subscription->ended()){
            return redirect()->route('settings');
        }

        return view('settings.subscribe', ['intent' => $request->user()->createSetupIntent()]);
    }


    public function subscribe_store(Request $request){

        /*
            * Subscribe page show card error in form
        */
        $user = $request->user();
        $trialEnd = Carbon::createFromTimestamp(strtotime($user->trial_ends_at));
        try {
            if($trialEnd < Carbon::now()){
                $user->newSubscription('default', 'price_1H90K9EtyrRgwUBdGoBhSEzL')
                    ->create($request['payment_method']); 
            }else {
                $user->newSubscription('default', 'price_1H90K9EtyrRgwUBdGoBhSEzL')
                    ->trialUntil($trialEnd)
                    ->create($request['payment_method']); 
            }
        }catch (IncompletePayment $exception){
            return redirect()->route('cashier.payment', [$exception->payment->id, 'redirect' => route('user_sets')]);
        }

        
        return redirect()->route('user_sets');
    }

}
