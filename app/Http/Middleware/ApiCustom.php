<?php

namespace App\Http\Middleware;

use Closure;

class ApiCustom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	$user = \App\User::find($request->id);

        if ($user) {
            if($user->api_token == $request->api_token)
		        return $next($request);
	        else
         		return response('You need to login again.', 401);
        }
        else
            return response('User not available please register first .', 401);
    }

}