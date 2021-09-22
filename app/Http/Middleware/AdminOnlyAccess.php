<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOnlyAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) 
        {
            return redirect('/');  
        }
        
        if (Auth::check())
        {
            $user = Auth::user();

            if ($user->type != 'admin')
            {
                return redirect('/');     
            }
        }
        return $next($request);
    }
}
