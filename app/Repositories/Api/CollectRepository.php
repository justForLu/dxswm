<?php

namespace App\Repositories\Api;

use App\Repositories\BaseRepository;

class CollectRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\Collect';
    }

    /**
     * 获取我收藏的店铺
     * @param array $params
     */
    public function getList($params = [])
    {

    }
}
