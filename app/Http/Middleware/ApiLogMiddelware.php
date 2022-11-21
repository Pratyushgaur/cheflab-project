<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class ApiLogMiddelware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
//        if ($request->expectsJson()) {
            Log::channel('your_channel_name')->info('\n\n----------------\n');
            Log::channel('your_channel_name')->info(URL::full());
            Log::channel('your_channel_name')->info($request->all());
//        }
        return $next($request);
    }
}
