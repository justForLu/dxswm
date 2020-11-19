<?php

namespace App\Repositories\Api;

use App\Enums\BasicEnum;
use App\Models\Common\Goods;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Config;

class CategoryRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\Category';
    }

    /**
     * 获取分类列表（有分页）
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

        if (isset($params['business_id']) && !empty($params['business_id'])) {
            $where[] = ['business_id', $params['business_id']];
        }
        if(isset($params['name']) && !empty($params['name'])) {
            $where[] = ['name','LIKE','%'.$params['name'].'%'];
        }

        $offset = ($page-1)*$size;

        $list = $model->where($where)
            ->orderBy($sortBy, $sortType)
            ->offset($offset)
            ->limit($size)
            ->get()->toArray();


        return $list;
    }

    /**
     * 根据店家ID获取分类及以下商品
     * @param array $params
     * @return mixed
     */
    public function getCatGoods($params = [])
    {
        //判断店家ID
        if(!isset($params['business_id']) || empty($params['business_id'])){
            return [];
        }


        $cat_list = $this->model->where('business_id',$params['business_id'])
            ->where('status', BasicEnum::ACTIVE)
            ->orderBy('sort','ASC')
            ->orderBy('id','DESC')
            ->get()->toArray();

        $cat_ids = array_column($cat_list,'id');

        if($cat_ids){
            $goods_list = Goods::whereIn('category_id', $cat_ids)
                ->where('status', BasicEnum::ACTIVE)
                ->orderBy('sort','ASC')
                ->orderBy('id','DESC')
                ->get()->toArray();

            foreach ($cat_list as &$v){
                foreach ($goods_list as &$goods){
                    if($v['id'] == $goods['category_id']){
                        $goods['image'] = Config::get('api.api_url').$goods['image'];
                        $goods['score'] = $goods['score'].'%';
                        $v['goods'][] = $goods;
                        unset($goods);
                    }
                }
            }

            return $cat_list;
        }

        return [];
    }



}
