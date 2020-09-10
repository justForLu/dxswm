<?php

namespace App\Http\Middleware;

use App\Repositories\Admin\LogRepository as Log;
use Closure;

class AdminWriteLog
{
    protected $log;

    public function __construct(Log $log)
    {
        $this->log = $log;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(env('APP_ADMIN_LOG',false)){
            // 开启日志记录
            $this->log->writeOperateLog($request);
        }
        return $next($request);
    }
}
