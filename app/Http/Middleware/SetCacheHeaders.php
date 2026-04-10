<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\SetCacheHeaders as Middleware;

class SetCacheHeaders extends Middleware
{
    /**
     * The cache headers that should be applied.
     *
     * @var array<int, string>
     */
    protected $headers = [
        'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
        'Pragma' => 'no-cache',
        'Expires' => 'Fri, 01 Jan 1990 00:00:00 GMT',
    ];
}
