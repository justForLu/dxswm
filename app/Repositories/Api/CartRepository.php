<?php

namespace App\Repositories\Api;

use App\Repositories\BaseRepository;

class CartRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\Cart';
    }

    /**
     * 获取购物车列表
     * @param array $params
     * @return mixed
     */
    public function getCart($params = [])
    {
        $where = [];

        if(!isset($params['business_id']) || empty($params['business_id'])){
            return -1;
        }
        if(!isset($params['user_id']) || empty($params['user_id'])){
            return -1;
        }

        $where[] = ['business_id', $params['business_id']];
        $where[] = ['user_id', $params['user_id']];

        $cart_info = $this->model->where($where)->first();

        $list = [];

        if(isset($cart_info['goods']) && $cart_info['goods']){
            $goods = json_decode($cart_info['goods'], true);
            if($goods && is_array($goods)){
                foreach ($goods as $v){
                    $list[$v['goods_id']] = $v;
                }
            }
        }

        return $list;
    }

    /**
     * 加入购物车
     * @param array $params
     * @return mixed
     */
    public function addCart($params = [])
    {
        $where = [];

        if(!isset($params['business_id']) || empty($params['business_id'])){
            return -1;
        }
        if(!isset($params['user_id']) || empty($params['user_id'])){
            return -1;
        }

        $where[] = ['business_id', $params['business_id']];
        $where[] = ['user_id', $params['user_id']];

        $cart_goods = [];
        if($params['goods'] && is_array($params['goods'])){
            foreach ($params['goods'] as $v){
                $number = $v['number'] ?? 0;
                $goods_id = $v['goods']['id'] ?? 0;
                if($number && $goods_id){
                    $cart_goods[] = ['goods_id' => $goods_id, 'number' => $number];
                }
            }
        }

        $goods = json_encode($cart_goods);

        $data = [
            'business_id' => $params['business_id'],
            'user_id' => $params['user_id'],
            'goods' => $goods
        ];

        $is_exist = $this->model->where($where)->count();
        if($is_exist){
            $data['update_time'] = time();

            $result = $this->model->where($where)->update($data);
        }else{
            $data['create_time'] = time();

            $result = $this->model->insert($data);
        }

        return $result;
    }

    /**
     * 清空购物车
     * @param array $params
     * @return mixed
     */
    public function delCart($params = [])
    {
        $where = [];

        if(!isset($params['business_id']) || empty($params['business_id'])){
            return -1;
        }
        if(!isset($params['user_id']) || empty($params['user_id'])){
            return -1;
        }
        $where[] = ['business_id', $params['business_id']];
        $where[] = ['user_id', $params['user_id']];

        $result = $this->model->where($where)->delete();

        return $result;
    }
}
