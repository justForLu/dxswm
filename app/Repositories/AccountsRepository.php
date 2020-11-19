<?php

namespace App\Repositories;


class AccountsRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Accounts';
    }

    /**
     * 根据tag获取公众号.
     * @param $tag
     * @return mixed
     */
    public function getByTag($tag)
    {
        return $this->findBy('tag',$tag);
    }

    /**
     * 根据appId获取公众号
     * @param $appId
     * @return mixed
     */
    public function getByAppId($appId){
        return $this->findBy('app_id',$appId);
    }
}
