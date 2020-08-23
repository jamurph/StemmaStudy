<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use Billable;

    protected $dates = [
        'trial_ends_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'trial_ends_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function sets(){
        return $this->hasMany(Set::class);
    }

    /**
     * Helper to determine if this User has the right to create new sets, cards, and connections.
     */
    public function onTrialOrSubscribed(){
        $onTrial = $this->onTrial();
        $subscription = $this->subscription('default');
        $subscribed = $subscription == null ? false : !$subscription->ended();
        return $onTrial || $subscribed;
    }
    
}
