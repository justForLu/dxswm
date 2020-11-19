<?php
namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class BaseController extends Controller
{

    protected $userInfo;

    protected $account;

    protected $callback;

    protected $accountConfig;

    protected $check;

    protected $business_id;

    /**
     * 父类构造器(接口请求拦截)
     * BaseController constructor.
     * @param $request
     */
    public function __construct(){
//        $this->account = $request->account;
//        $this->accountConfig = json_decode($this->account['account_config'],true);
//        //暂时定死的数据
//        $this->business_id = 3;
//        //$this->userInfo->id = 1;
//        //$this->userInfo->name = '尼古拉斯';
//        //$this->userInfo->mobile = '15924140778';
//
//        $this->callback = isset($_SERVER['HTTP_REFERER']) ? urlencode($_SERVER['HTTP_REFERER']) : '';
//        view()->share('callback',$this->callback);
    }

    /**
     * 检查用户信息是否完善
     */
    public function checkUserInfo(){
        if(!$this->userInfo || !$this->userInfo->name || !$this->userInfo->mobile){
            return redirect()->to('home/user_complete?callback='.urlencode(url()->full()))->send();
        }else{
            view()->share('userInfo',$this->userInfo);
        }
    }

    /**
     * 自动返回成功和失败内容
     * @param $flag
     * @param string $msg
     * @param string $referrer
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxAuto($flag,$msg = '操作',$referrer = '')
    {
        if($flag !== false){
            return $this->ajaxSuccess(null,$msg.'成功',$referrer);
        }else{
            return $this->ajaxError($msg.'失败',$referrer);
        }
    }

    /**
     * ajax返回成功内容
     * @param null $data
     * @param string $msg
     * @param string $referrer
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxSuccess($data = null, $msg = 'ok',$referrer = '', $code = 200)
    {
        $ajaxData = array();

        $ajaxData['status'] = 'success';
        $ajaxData['msg'] = $msg;
        $ajaxData['data'] = $data;
        $ajaxData['code'] = $code;
        $ajaxData['referrer'] = $referrer;

        header("Access-Control-Allow-Origin: *");
        return response()->json($ajaxData);
    }

    /**
     * ajax返回失败内容
     * @param string $msg
     * @param string $referrer
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxError($msg = 'fail', $referrer = '', $code = 300)
    {
        $ajaxData = array();

        $ajaxData['status'] = 'fail';
        $ajaxData['msg'] = $msg;
        $ajaxData['code'] = $code;
        $ajaxData['referrer'] = $referrer;

        header("Access-Control-Allow-Origin: *");
        return response()->json($ajaxData);
    }

}
