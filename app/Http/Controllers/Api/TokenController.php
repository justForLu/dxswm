<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class TokenController extends BaseController
{

    public function __construct()
    {
        parent::__construct();


    }

    public function getToken(Request $request)
    {
        $params = $request->all();

        $result = $this->checkSignature($params);
        if($result){
            echo $_GET['echostr'];;
            exit;
        }
    }
    /**
     * 检查标签
     * @param array $params
     * @return bool
     */
    function checkSignature($params = [])
    {
        //先获取到这三个参数
        $signature = $params['signature'];
        $nonce = $params['nonce'];
        $timestamp = $params['timestamp'];

        //把这三个参数存到一个数组里面
        $token = Config::get('admin.token');
        $tmpArr = array($timestamp, $nonce, $token);
        //进行字典排序
        sort($tmpArr);

        //把数组中的元素合并成字符串，impode()函数是用来将一个数组合并成字符串的
        $tmpStr = implode($tmpArr);

        //sha1加密，调用sha1函数
        $tmpStr = sha1($tmpStr);
        //判断加密后的字符串是否和signature相等
        if ($tmpStr == $signature) {

            return true;
        }
        return false;
    }


}




