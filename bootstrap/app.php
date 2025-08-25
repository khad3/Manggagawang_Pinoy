<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'applicant.authenticate' => App\Http\Middleware\ApplicantAuthenticate::class,
             'tesda-officer.authenticate' => App\Http\Middleware\TesdaOfficer\TesdaOfficerAuthenticate::class,
             'employer.authenticate' => App\Http\Middleware\EmployerAuthenticate::class,
             'admin.authenticate' => App\Http\Middleware\Admin\AdminAuthenticate::class,
        ]);

        
           
       


    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
