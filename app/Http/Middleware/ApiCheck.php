<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class ApiCheck
{
    /**
     * The permission of the url that should not be checked.
     * @var array
     */
    protected $except = [
        //
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // 获取控制器和方法名
        $action = get_action_name();

        $code = $action['controller'] . "." . $action['method'];

        Log::info('check');
        return $next($request);
    }
}
