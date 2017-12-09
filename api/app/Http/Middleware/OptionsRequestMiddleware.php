<?php

namespace App\Http\Middleware;
use Closure;

class OptionsRequestMiddleware 
{

	public function handle($request, Closure $next)
	{
		reponseCrossDomain();
		if($request->isMethod('options')){
			return 1;
		}
		return $next($request);
	}
}