<?php

namespace App\Repositories\Api;

use App\Enums\BasicEnum;
use App\Repositories\BaseRepository;

class CityRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\City';
    }

    /**
     * 获取城市列表
     * @param array $params
     * @param string $field
     * @return mixed
     */
    public function getList($params = [], $field = '*')
    {
        $where = [];
        $where[] = ['status', BasicEnum::ACTIVE];

        if (isset($params['parent'])) {
            $where[] = ['parent', $params['parent']];
        }
        if(isset($params['grade'])) {
            $where[] = ['grade', $params['grade']];
        }

        $list = $this->model->select($field)->where($where)
            ->orderBy('sort','DESC')
            ->get()->toArray();

        return $list;
    }

}
