<?php

namespace App\Repositories\Admin;


use App\Enums\BasicEnum;
use App\Enums\ModuleEnum;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class LogRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Admin\Log';
    }

    /**
     * 记录操作日志
     * @param $request
     * @param $content
     */
    public function writeOperateLog($request, $content = ''){
        // 记录post请求
        if($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('delete')){
            $action = get_action_name();
            $params = $request->all();
            unset($params['_token']);unset($params['_method']);

            $log = array(
                'user_id' => Auth::guard()->user()->id,
                'operate_module' => $action['controller'],
                'operate_action' => $action['method'],
                'operate_url' => $request->getRequestUri(),
                'content' => $content,
                'ip' => get_client_ip(),
                'module' => ModuleEnum::ADMIN,
                'create_time' => time()
            );

            $this->saveModel($log);
        }
    }
}
