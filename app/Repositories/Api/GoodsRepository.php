<?php

namespace App\Repositories\Api;

use App\Enums\BasicEnum;
use App\Models\Common\Business;
use App\Repositories\BaseRepository;

class GoodsRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\Goods';
    }


    /**
     * 获取商品列表（有分页）
     * @param array $params
     * @param string $field
     * @return mixed
     */
    public function getList($params = [], $field = '*')
    {
        $page = isset($params['page']) && $params['page'] > 0 ? $params['page'] : 1;
        $size = isset($params['size']) && $params['size'] > 0 ? $params['size'] : 10;
        $sortBy = isset($params['sortBy']) && !empty($params['sortBy']) ? $params['sortBy'] : 'id';
        $sortType = isset($params['sortType']) && !empty($params['sortType']) ? $params['sortType'] : 'DESC';

        $where = [];
        $where[] = ['status', BasicEnum::ACTIVE];

        $model = $this->model->select($field);

        if (isset($params['school_id']) && !empty($params['school_id'])) {
            //查询所有商家ID，然后作为搜索条件
            $business_id = Business::where('school',$params['school_id'])->pluck('id');
            $model = $model->whereIn('business_id', $business_id);
        }
        if (isset($params['business_id']) && !empty($params['business_id'])) {
            $where[] = ['business_id', $params['business_id']];
        }
        if(isset($params['name']) && !empty($params['name'])) {
            $where[] = ['name','LIKE','%'.$params['name'].'%'];
        }
        if(isset($params['category_id']) && !empty($params['category_id'])) {
            $where[] = ['category_id', $params['category_id']];
        }
        if(isset($params['min_price']) && !empty($params['min_price'])) {
            $where[] = ['price','>=',$params['min_price']];
        }
        if(isset($params['max_price']) && !empty($params['max_price'])){
            $where[] = ['price', '<=', $params['max_price']];
        }
        if(isset($params['is_recommend']) && !empty($params['is_recommend'])){
            $where[] = ['is_recommend', $params['is_recommend']];
        }

        $offset = ($page-1)*$size;

        $list = $model->where($where)
            ->orderBy($sortBy, $sortType)
            ->offset($offset)
            ->limit($size)
            ->get()->toArray();


        return $list;
    }
}
