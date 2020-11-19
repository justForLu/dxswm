<?php

namespace App\Repositories\Api;

use App\Enums\BasicEnum;
use App\Repositories\BaseRepository;

class AddressRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\Address';
    }

    /**
     * 获取地址列表（有分页）
     * @param array $params
     * @param string $field
     * @return mixed
     */
    public function getList($params = [], $field = '*')
    {
        $list = $this->model->select($field)->where('user_id',$params['user_id'])
            ->orderBy('is_default','DESC')
            ->get()->toArray();

        return $list;
    }

    /**
     * 保存地址信息
     * @param array $params
     * @return mixed
     */
    public function saveAddress($params = [])
    {
        $is_default = isset($params['is_default']) ? $params['is_default'] : 0;
        //只能有一个默认地址
        if($is_default){
            $this->model->where('user_id',1)->update(['is_default' => 0, 'update_time' => time()]);
        }
        if(!isset($params['user_id']) || empty($params['user_id'])){
            return -1;
        }

        $data = [
            'user_id' => $params['user_id'],
            'name' => $params['name'] ?? '',
            'mobile' => $params['mobile'] ?? '',
            'school_id' => $params['school_id'] ?? 0,
            'address' => $params['address'] ?? '',
            'longitude' => $params['longitude'] ?? 0,
            'latitude' => $params['latitude'] ?? 0,
            'is_default' => $is_default,
            'create_time' => time(),
        ];

        $id = $this->model->insertGetId($data);

        return $id;
    }

    /**
     * 获取地址信息
     * @param array $params
     * @param string $field
     * @return mixed
     */
    public function getInfo($params = [], $field = '*')
    {
        $where = [];

        if(isset($params['id']) && !empty($params['id'])){
            $where[] = ['id', $params['id']];

        }
        if(isset($params['user_id']) && !empty($params['user_id'])){
            $where[] = ['user_id', '=', $params['user_id']];
        }
        if(isset($params['is_default'])){
            $where[] = ['is_default', $params['is_default']];
        }

        $data = $this->model->select($field)->where($where)->first();

        if($data){
            $data->score = $data->score.'%';
        }

        return $data;
    }

    /**
     * 更新地址信息
     * @param array $params
     * @return mixed
     */
    public function updAddress($params = [])
    {
        $is_default = isset($params['is_default']) ? $params['is_default'] : 0;
        //只能有一个默认地址
        if($is_default){
            $this->model->where('user_id',1)->update(['is_default' => 0, 'update_time' => time()]);
        }

        $data = [
            'name' => $params['name'] ?? '',
            'mobile' => $params['mobile'] ?? '',
            'school_id' => $params['school_id'] ?? 0,
            'address' => $params['address'] ?? '',
            'longitude' => $params['longitude'] ?? 0,
            'latitude' => $params['latitude'] ?? 0,
            'is_default' => $is_default,
            'update_time' => time(),
        ];

        $id = $this->model->where('id',$params['id'])->update($data);

        return $id;
    }
}
