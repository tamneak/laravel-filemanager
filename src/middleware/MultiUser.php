<?php 

namespace Unisharp\Laravelfilemanager\middleware;

use Closure;

class MultiUser
{
    public function handle($request, Closure $next)
    {
    	if (\Config::get('lfm.allow_multi_user') === true) {
	        \Auth::user()->user_field = eval('return '.config('lfm.user_field').';');

	        if ($request->input('base') == null) {
	            $request->merge(['base' => \Auth::user()->user_field]);
	        } elseif (strpos($request->input('base'), \Auth::user()->user_field) === false) {
	            $request->replace(['base' => \Auth::user()->user_field]);
	        }
	    }

        return $next($request);
    }
}