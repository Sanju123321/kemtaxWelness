<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Daily Cap Warning Schedule
| Runs at 9PM, 10PM, 11PM, 11:30PM, 11:45PM every day.
| Uses increasing thresholds (70/80/90/95/100%) to nudge users to upgrade.
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Income Distribution Schedule
| Dispatches DistributeIncomeJob for all active-plan users every minute.
| Run `php artisan queue:work` in a separate terminal to process the jobs.
|--------------------------------------------------------------------------
*/
Schedule::command('income:distribute')
    ->everyMinute()
    ->appendOutputTo(storage_path('logs/income-distribute.log'));

Schedule::command('cap:warn')->dailyAt('21:00')->appendOutputTo(storage_path('logs/cap-warn.log'));
Schedule::command('cap:warn')->dailyAt('22:00')->appendOutputTo(storage_path('logs/cap-warn.log'));
Schedule::command('cap:warn')->dailyAt('23:00')->appendOutputTo(storage_path('logs/cap-warn.log'));
Schedule::command('cap:warn')->at('23:30')->appendOutputTo(storage_path('logs/cap-warn.log'));
Schedule::command('cap:warn')->at('23:45')->appendOutputTo(storage_path('logs/cap-warn.log'));
Schedule::command('auth:audit-hashes')
    ->dailyAt('02:30')
    ->appendOutputTo(storage_path('logs/auth-hash-audit.log'));
Schedule::command('ops:monitor-failures')
    ->everyFiveMinutes()
    ->appendOutputTo(storage_path('logs/failure-monitor.log'));
Schedule::command('queue:work --stop-when-empty --tries=3')
    ->everyMinute()
    ->withoutOverlapping()
    ->runInBackground();