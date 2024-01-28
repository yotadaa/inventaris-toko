<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Storage;

class ProtectAssetsMiddleware
{
    public function handle($request, Closure $next)
    {
        // Get the requested file path
        $filePath = public_path($request->path());

        // Check if the file exists
        if (file_exists($filePath)) {
            // Deny access and return a 403 Forbidden response
            return abort(403, 'Access forbidden.');
        }

        // Allow access to the file
        return $next($request);
    }
}
