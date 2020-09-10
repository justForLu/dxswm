<?php
/**
 * Created by PhpStorm.
 * User: Yolanda
 * Date: 2017/10/12
 * Time: 9:42
 */

namespace App\Repositories;

use Redis;
use Bosnadev\Repositories\Eloquent\Repository;

abstract class BaseRepository extends Repository
{
    /**
     * 批量插入数据
     * @param $data
     * @return mixed
     */
    public function insertBatch($data){
        return $this->model->insert($data);
    }

    /**
     * redis连接
     */
    public function redis()
    {
        $redis = new Redis();
        $redis->connect(config('admin.redis.host'), config('admin.redis.port'));

        if(config('admin.redis.prefix')){
            $redis->setOption(Redis::OPT_PREFIX, config('admin.redis.prefix'));
        }
        if(config('admin.redis.password')){
            $redis->auth(config('admin.redis.password'));
        }
        if(config('admin.redis.db')){
            $redis->select(config('admin.redis.db'));
        }
        return $redis;
    }
}