<?php
namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected $gateway  = 'http://gw.api.taobao.com/router/rest';   // 短信接口网关

    protected $appKey;

    protected $secretKey;

    protected $signName;

    protected $method = 'alibaba.aliqin.fc.sms.num.send';   // 短信接口名称

    protected $signMethod = 'md5';

    protected $sign;

    protected $format = 'json';

    protected $apiVersion = '2.0';

    public $connectTimeout;

    public $readTimeout;

    /**
     * 短信模板ID
     * telus用户注册/修改密码验证码:  SMS_113675020    Your Telus verification code is ${code}
     */
    public function __construct()
    {

        $this->appKey = '24711093';
        $this->secretKey = 'd8258551d7122390d18097bf7e6571eb';
        $this->signName = '利尔达';
    }

    /**
     * 组装系统参数
     * @param $apiParams
     * @return mixed
     */
    public function sysParams($apiParams){
        $sysParams = array();
        $sysParams['method'] = $this->method;
        $sysParams['app_key'] = $this->appKey;
        $sysParams['sign_method'] = $this->signMethod;
        $sysParams['timestamp'] = get_date();
        $sysParams['format'] = $this->format;
        $sysParams['v'] = $this->apiVersion;
        $sysParams["sign"] = $this->generateSign(array_merge($apiParams, $sysParams));

        return $sysParams;
    }

    /**
     * 组装业务参数
     * @param $mobile
     * @param $sms
     * @param $template
     * @return mixed
     */
    public function apiParams($mobile,$sms,$template){
        $apiParams = array();
        $apiParams['sms_type'] = 'normal';
        $apiParams['sms_free_sign_name'] = $this->signName;
        $apiParams['sms_param'] = json_encode($sms);
        $apiParams['rec_num'] = $mobile;
        $apiParams['sms_template_code'] = $template;

        return $apiParams;
    }

    /**
     * 参数签名
     * @param $params
     * @return string
     */
    public function generateSign($params){
        ksort($params);

        $stringToBeSigned = $this->secretKey;
        foreach ($params as $k => $v)
        {
            if(is_string($v) && "@" != substr($v, 0, 1))
            {
                $stringToBeSigned .= "$k$v";
            }
        }
        unset($k, $v);
        $stringToBeSigned .= $this->secretKey;

        return strtoupper(md5($stringToBeSigned));
    }

    /**
     * 发送短信消息
     * @param $mobile
     * @param $sms
     * @param $template
     * @return bool
     */
    public function send($mobile,$sms,$template){
        $apiParams = $this->apiParams($mobile,$sms,$template);
        $sysParams = $this->sysParams($apiParams);

        $requestUrl = $this->gateway . "?";

        foreach($sysParams as $sysParamKey => $sysParamValue)
        {
            $requestUrl .= "$sysParamKey=" . urlencode($sysParamValue) . "&";
        }

        $fileFields = array();
        foreach ($apiParams as $key => $value) {
            if(is_array($value) && array_key_exists('type',$value) && array_key_exists('content',$value) ){
                $value['name'] = $key;
                $fileFields[$key] = $value;
                unset($apiParams[$key]);
            }
        }

        $requestUrl = substr($requestUrl, 0, -1);

        //发起HTTP请求
        try
        {
            $resp = $this->curl($requestUrl, $apiParams);
            $respObject = json_decode($resp);

            if($resp != null){
                foreach ($respObject as $propKey => $propValue)
                {
                    $respObject = $propValue;
                }

                if(is_object($respObject->result) && $respObject->result->success != null){
                    return $respObject->result->success;
                }else{
                    return $respObject->result->sub_code;
                }

            }else{
                return false;
            }
        }
        catch(Exception $e)
        {
            Log::info('[短信发送异常]：' . $e->getMessage());
            return false;
        }
    }

    /**
     * 发送curl请求
     * @param $url
     * @param null $postFields
     * @return mixed
     * @throws Exception
     */
    public function curl($url, $postFields = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($this->readTimeout) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->readTimeout);
        }
        if ($this->connectTimeout) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        }
        curl_setopt ( $ch, CURLOPT_USERAGENT, "top-sdk-php" );
        //https 请求
        if(strlen($url) > 5 && strtolower(substr($url,0,5)) == "https" ) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        if (is_array($postFields) && 0 < count($postFields))
        {
            $postBodyString = "";
            $postMultipart = false;
            foreach ($postFields as $k => $v)
            {
                if(!is_string($v))
                    continue ;

                if("@" != substr($v, 0, 1))//判断是不是文件上传
                {
                    $postBodyString .= "$k=" . urlencode($v) . "&";
                }
                else//文件上传用multipart/form-data，否则用www-form-urlencoded
                {
                    $postMultipart = true;
                    if(class_exists('\CURLFile')){
                        $postFields[$k] = new \CURLFile(substr($v, 1));
                    }
                }
            }
            unset($k, $v);
            curl_setopt($ch, CURLOPT_POST, true);
            if ($postMultipart)
            {
                if (class_exists('\CURLFile')) {
                    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
                } else {
                    if (defined('CURLOPT_SAFE_UPLOAD')) {
                        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
                    }
                }
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            }
            else
            {
                $header = array("content-type: application/x-www-form-urlencoded; charset=UTF-8");
                curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
                curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString,0,-1));
            }
        }
        $reponse = curl_exec($ch);

        if (curl_errno($ch))
        {
            throw new Exception(curl_error($ch),0);
        }
        else
        {
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (200 !== $httpStatusCode)
            {
                throw new Exception($reponse,$httpStatusCode);
            }
        }
        curl_close($ch);
        return $reponse;
    }
}