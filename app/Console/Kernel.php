<?php

namespace App\Console;

use App\Notifications\DueForReview;
use App\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        //Email Users who have more than 5 cards due
        $schedule->call(function(){
            foreach(User::all() as $user){
                $totalDue = 0;
                foreach($user->sets as $set){
                    $countDue = $set->cards->where('next_review', '<', Carbon::now())->count();
                    $totalDue += $countDue;
                }

                if($totalDue > 5){
                    $user->notify(new DueForReview($totalDue));
                }
            };
        })  
            ->dailyAt('18:00')
            ->timezone('America/New_York')
        ;

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
