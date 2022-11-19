<?php

namespace App\Http\Middleware;

use Closure;
use \Carbon\Carbon;
use App\Models\Counter;
use Illuminate\Http\Request;

class CounterVerifyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $now = Carbon::now()->format('Y-m-d H:i');

        $counter = Counter::firstOrCreate(['date' => $now]);
        $counter_date = $counter->date->format('Y-m-d H:i');

        if ($counter->count == 3 && $counter_date == $now) {
            return response()->json([
                'success' => false,
                'message' => 'Has superado el límite de consultas permitidas'
            ], 200);
        } else {
            $counter->count += 1;
            $counter->save();
        }


        return $next($request); 
    }
}
