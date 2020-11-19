<?php

namespace App\Repositories\Api;

use App\Enums\BasicEnum;
use App\Repositories\BaseRepository;

class BusinessRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\Business';
    }

    /**
     * 获取店家列表（有分页）
     * @param array $params
     * @param string $field
     * @return mixed
     */
    public function getList($params = [], $field = '*')
    {
        $page = isset($params['page']) && $params['page'] > 0 ? $params['page'] : 1;
        $size = isset($params['size']) && $params['size'] > 0 ? $params['size'] : 10;
        $sortBy = isset($params['sortBy']) && !empty($params['sortBy']) ? $params['sortBy'] : 'status';
        $sortType = isset($params['sortType']) && !empty($params['sortType']) ? $params['sortType'] : 'ASC';

        $where = [];
        $where[] = ['status', BasicEnum::ACTIVE];

        $model = $this->model->select($field);

        if (isset($params['school_id']) && !empty($params['school_id'])) {
            $where[] = ['school', $params['school_id']];
        }
        if(isset($params['name']) && !empty($params['name'])) {
            $where[] = ['name','LIKE','%'.$params['name'].'%'];
        }
        if(isset($params['category_id']) && !empty($params['category_id'])) {
            $where[] = ['category_id', $params['category_id']];
        }

        $count = $model->where($where)->count();
        $page_count = ceil($count/10);

        $offset = ($page-1)*$size;

        $list = $model->where($where)
            ->orderBy($sortBy, $sortType)
            ->offset($offset)
            ->limit($size)
            ->get()->toArray();


        return ['list' => $list, 'page_count' => $page_count];
    }

    /**
     * 获取店家信息
     * @param array $params
     * @param string $field
     * @return mixed
     */
    public function getInfo($params = [], $field = '*')
    {
        $where = [];

        if(isset($params['business_id']) && !empty($params['business_id'])){
            $where[] = ['id', '=', $params['business_id']];
        }

        $data = $this->model->select($field)->where($where)->first();

        if($data){
            if(isset($data->score)){
                $data->score = $data->score.'%';
            }
        }

        return $data;
    }

    /**
     * 收藏/取消收藏店家
     * @param array $params
     */
    public function collectBusiness($params = [])
    {

    }

}
