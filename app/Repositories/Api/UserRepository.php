<?php

namespace App\Repositories\Api;

use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\User';
    }

    /**
     * 根据openID获取用户信息
     * @param $openId
     * @return mixed
     */
    public function getUserInfo($openId){
        return $this->findWhere(array('openid' => $openId))->first();
    }

}
