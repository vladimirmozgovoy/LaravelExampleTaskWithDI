<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Log;
use App\Models\User;

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
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $schedule->call(function () {
            $users = User::whereHas('roles', function ($q) {
                $q->whereIn('name', ['courier', 'collector']);
            })->get();
            foreach ($users as $user) {
                if($user->active) {
                    $user->update(['active' => 0]);
                    $user->shifts()->create([
                        'active' => false
                    ]);
                }
            }
        })->dailyAt('21:00');

        $schedule->call(function () {
            $log = "schedule test" . date('d.m.Y h:i');
            Log::debug($log);
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
