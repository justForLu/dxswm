<?php

namespace App\Repositories\Api;

use App\Enums\GenderEnum;
use App\Enums\UserEnum;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Redis;

class UserRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\User';
    }

    /**
     * 微信公众号、小程序静默登陆操作
     * @param array $params
     * @return array|bool
     * @throws \ReflectionException
     */
    public function silentLogin($params = [])
    {
        //判断数据库中是否有数据，有数据则直接登陆，否则先插入用户信息再进行登陆
        if($params){
            $openid = $params['openid'] ?? '';
            if($openid){
                $is_exist = $this->model->where('openid', $openid)->count();
                if($is_exist == 0){  //如果不存在，则先插入信息到数据库
                    $data = [
                        'openid' => $openid,
                        'nickname' => $params['nickname'] ?? '',
                        'gender' => $params['sex'] ?? '',
                        'headimgurl' => $params['headimgurl'] ?? '',
                        'status' => UserEnum::ACTIVE,
                        'create_time' => time()
                    ];
                    //加密盐默认为4位随机数
                    $salt = mt_rand(1000,9999);
                    $data['salt'] = $salt;
                    //默认密码明文是123456
                    $password = $this->createPassword('123456', $salt);
                    $data['password'] = $password;

                    $ret = $this->model->insert($data);
                    if(!$ret){
                        //如果插入失败，返回false
                        return false;
                    }
                }

                //执行登陆操作
                $data_login = [
                    'login_time' => time(),
                    'login_ip' => get_client_ip(),
                    'update_time' => time()
                ];

                $this->model->where('openid', $openid)->update($data_login);

                $user = $this->model->where('openid', $openid)->first();

                if($user){
                    $userInfo = [
                        'id' => $user->id,
                        'nickname' => $user->nickname,
                        'headimgurl' => $user->headimgurl,
                        'gender' => $user->gender,
                        'gender_name' => GenderEnum::getDesc($user->gender),
                        'mobile' => $user->mobile,
                        'login_time' => $user->login_time,
                        'login_ip' => $user->login_ip,
                        'is_business' => $user->is_business,
                        'is_rider' => $user->is_rider,
                        'status' => $user->status
                    ];
                    //token生成方式：MD5（密码+加密盐+mobile+login_time+login_ip）
                    $token = $this->createToken($user->password,$user->salt,$user->mobile,$user->login_time,$user->login_ip);

                    //token为键，保存用户信息，有效期1天
                    Redis::setex($token,86400, $user);

                    return ['token' => $token, 'userInfo' => $userInfo];
                }
            }
        }

        return false;
    }

    /**
     * 发送验证码
     * @param array $params
     * @return mixed
     */
    public function sendCode($params = [])
    {

    }

    /**
     * 普通登陆
     * @param array $params
     * @return array
     * @throws \ReflectionException
     */
    public function appLogin($params = [])
    {
        if(!isset($params['username']) || empty($params['username'])){
            return ['data' => '', 'code' => -1, 'msg' => '请填写用户名'];
        }
        if(!isset($params['password']) || empty($params['password'])){
            return ['data' => '', 'code' => -1, 'msg' => '请填写密码'];
        }

        //验证用户信息
        $user = $this->model->where('username', $params['username'])
            ->orWhere('mobile', $params['username'])
            ->first();

        //判断用户信息是否存在
        if(empty($user)){
            return ['data' => '', 'code' => -1, 'msg' => '用户信息不存在'];
        }
        //判断用户状态
        if($user->status != UserEnum::ACTIVE){
            return ['data' => '', 'code' => -1, 'msg' => '该用户目前禁止登陆'];
        }
        //验证用户密码
        $password = $this->createPassword($params['password'], $user->salt);
        if($password != $user->password){
            return ['data' => '', 'code' => -1, 'msg' => '密码错误'];
        }

        //验证完成之后，更新用户登录信息，并生成token，保存用户信息在Redis里
        $data = [
            'login_time' => time(),
            'login_ip' => get_client_ip(),
            'update_time' => time()
        ];

        $ret = $this->model->where('id', $user->id)->update($data);

        if($ret){
            $user->login_time = $data['login_time'];
            $user->login_ip = $data['login_ip'];

            $userInfo = [
                'id' => $user->id,
                'nickname' => $user->nickname,
                'headimgurl' => $user->headimgurl,
                'gender' => $user->gender,
                'gender_name' => GenderEnum::getDesc($user->gender),
                'mobile' => $user->mobile,
                'login_time' => $user->login_time,
                'login_ip' => $user->login_ip,
                'is_business' => $user->is_business,
                'is_rider' => $user->is_rider,
                'status' => $user->status
            ];

            $token = $this->createToken($password, $user->salt, $user->mobile, $data['login_time'], $data['login_ip']);

            //保存用户信息到Redis，有效期为15天
            Redis::setex($token, 1296000, $user);

            return ['token' => $token, 'userInfo' => $userInfo];
        }

        return ['data' => '', 'code' => -1, 'msg' => '登陆失败'];
    }

    /**
     * 普通注册
     * @param array $params
     * @return mixed
     */
    public function appRegister($params = [])
    {
        if(!isset($params['mobile']) || empty($params['mobile'])){
            return ['data' => '', 'code' => -1, 'msg' => '请填写手机号'];
        }
        if(!isset($params['password']) || empty($params['password'])){
            return ['data' => '', 'code' => -1, 'msg' => '请填写密码'];
        }


    }

    /**
     * 生成密码
     * @param string $password  这是密码明文
     * @param string $salt
     * @return string
     */
    public function createPassword($password = '', $salt = '')
    {
        return md5($password.$salt);
    }

    /**
     * 生成登陆时需要返回给前端的token
     * @param string $password  这是加密后的密码
     * @param string $salt
     * @param string $mobile
     * @param int $login_time
     * @param string $login_ip
     * @return string
     */
    public function createToken($password = '', $salt = '', $mobile = '', $login_time = 0, $login_ip = '')
    {
        //token生成方式：MD5（密码+加密盐+mobile+login_time+login_ip）
        $token = md5($password.$salt.$mobile.$login_time.$login_ip);

        return $token;
    }

    /**
     * 根据openID获取用户信息
     * @param $openId
     * @return mixed
     */
    public function getUserInfo($openId){
        return $this->findWhere(array('openid' => $openId))->first();
    }

    /**
     * 根据用户ID获取用户信息
     * @param $user_id
     * @return mixed
     */
    public function getUserById($user_id)
    {
        $user = $this->model->select('id','nickname','headimgurl','gender','mobile','login_time','login_ip','status')->find($user_id);

        return $user;
    }
}
