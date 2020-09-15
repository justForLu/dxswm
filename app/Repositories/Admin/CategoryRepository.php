<?php

namespace App\Repositories\Admin;

use App\Enums\BasicEnum;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\Category';
    }

    /**
     * 获取分类列表
     * @param array $where
     * @param string $select
     * @return mixed
     */
    public function getList($where = [], $select = '*')
    {
        $list = $this->model->select($select)
            ->where($where)
            ->where('status',BasicEnum::ACTIVE)
            ->get()->toArray();

        return $list;
    }

    /**
     * 根据type获取分类列表
     * @param int $type
     * @return array
     */
    public function getCategoryList($type = 0)
    {
        if($type){
            $list = $this->model->where('type',$type)
                ->where('pid',0)
                ->get();
            if($list){
                foreach ($list as &$v){
                    $child = $this->model->where('type',$type)
                        ->where('pid',$v->id)
                        ->get();
                    $v['children'] = $child;
                }
            }
            return $list;
        }

        return [];
    }
}
