<?php

namespace App\Repositories\Api;

use App\Enums\BasicEnum;
use App\Repositories\BaseRepository;

class SchoolRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\School';
    }

    /**
     * 获取高校列表
     * @param array $params
     * @param string $field
     * @return mixed
     */
    public function getList($params = [], $field = '*')
    {
        $where = [];
        $where[] = ['status', BasicEnum::ACTIVE];

        if (isset($params['province']) && !empty($params['province'])) {
            $where[] = ['province', $params['province']];
        }
        if(isset($params['city']) && !empty($params['city'])) {
            $where[] = ['city', $params['city']];
        }
        if(isset($params['area']) && !empty($params['area'])){
            $where[] = ['area', $params['area']];
        }

        $list = $this->model->select($field)->where($where)
            ->get()->toArray();

        return $list;
    }


    /**
     * 根据ID获取高校信息
     * @param array $params
     * @param string $field
     * @return mixed
     */
    public function getInfoById($params = [], $field = '*')
    {
        $data = [];
        $where = [];

        if(isset($params['school_id']) && !empty($params['school_id'])){
            $where[] = ['id', '=', $params['school_id']];
        }
        if($where){
            $data = $this->model->select($field)->where($where)->first();
        }

        return $data;
    }

}
