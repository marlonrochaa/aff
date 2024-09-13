<?php

use App\Console\Commands\SyncAffiliate;
use App\Console\Commands\SyncCommission;
use App\Console\Commands\SyncSheet;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command(SyncAffiliate::class)->everyFifteenMinutes();
        $schedule->command(SyncCommission::class)->everyThirtyMinutes();
       // $schedule->command(SyncSheet::class)->everyThirtyMinutes();
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
