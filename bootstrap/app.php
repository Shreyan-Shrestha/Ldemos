<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

(new \Bugsnag\BugsnagLaravel\OomBootstrapper())->bootstrap();

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->dontReportDuplicates();
        $exceptions->report(function (RuntimeException $e) {
            // Log the exception or perform any custom reporting logic here
           activity('error')
           ->withProperties([
                            'exception_class' => "Run Time Exception",
                            'exception_message' => $e->getMessage(),
                            'exception_file' => $e->getFile(),
                            'exception_line' => $e->getLine(),
                            'exception_code' => $e->getCode(),
                            'timestamp' => now()->toDateTimeString(),
                            'session_id' => session()->getId(),
                            'referer' => request()->headers->get('referer'),   
                            'headers' => json_encode(request()->headers->all()),
                            'cookies' => request()->cookies->all(),
                            'route_name' => Route::currentRouteName(),
                            'route'=> Route::current() ? Route::current()->uri() : null,
                            'method'=> request()->method(),
                            'url'=> request()->fullUrl(),
                            'user_agent'=> request()->userAgent()
                            ])
           ->log('Test RuntimeException occurred: ');
        });
    })->create();
