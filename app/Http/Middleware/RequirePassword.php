<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\RequirePassword as Middleware;

class RequirePassword extends Middleware
{
    /**
     * Get the URI that should be protected.
     *
     * @return array<int, string>
     */
    protected function passwordIsConfirmedFor(): array
    {
        return [
            '/settings',
            '/profile',
        ];
    }
}
