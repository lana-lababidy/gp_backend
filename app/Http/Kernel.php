<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
  protected $middlewareGroups = [
    'api' => [
        'throttle:api',
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
];
protected $routeMiddleware = [
    'auth'  => \App\Http\Middleware\Authenticate::class,
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
];

}
