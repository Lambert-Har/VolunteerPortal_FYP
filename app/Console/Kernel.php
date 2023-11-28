<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            try {
                Log::info('Scheduled task started at ' . now());
                
                // Query and delete records that match the criteria.
                DB::table('users')
                    ->where('isVerified', 0)
                    ->where('created_at', '<', now()->subMinutes(3))
                    ->delete();
                
                Log::info('Scheduled task finished at ' . now());
            } catch (\Exception $e) {
                Log::error('Scheduled task encountered an error: ' . $e->getMessage());
            }
        })->everyThreeMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
