<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Http\Controllers\Admin\BaseController;

class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
//        if (Auth::guard('api')->guest()) {
//            if ($request->ajax() || $request->wantsJson()) {
//                $ajaxData = array();
//
//                $ajaxData['status'] = 'success';
//                $ajaxData['msg'] = '请先登录';
//                $ajaxData['code'] = '300';
//                $ajaxData['referrer'] = url('/home/login');
//
//                return response()->json($ajaxData);
//            } else {
//                return redirect()->guest('home/login');
//            }
//        }

        return $next($request);
    }

}
