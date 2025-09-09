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
    'role' => \App\Http\Middleware\RoleMiddleware::class,
    'auth'  => \App\Http\Middleware\Authenticate::class,

  ];
}
