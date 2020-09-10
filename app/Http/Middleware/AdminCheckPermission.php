<?php

namespace App\Http\Middleware;

use App\Http\Requests\Request;
use Closure;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AdminCheckPermission
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
    public function handle($request, Closure $next)
    {
        Log::info('这里');
        // 获取控制器和方法名
        $action = get_action_name();

        $code = $action['controller'] . "." . $action['method'];

        if(Gate::denies($code) && !in_array($request->getPathInfo(),$this->except)) {
            if($request->ajax()){
                return response()->json(array('status'=>'fail','msg'=>'对不起，你没有权限','code'=>403,'referrer'=>''));
            }else{
                abort(403, '对不起，你没有权限');
            }
        }
        return $next($request);
    }
}
