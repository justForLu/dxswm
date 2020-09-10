<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Admin\Category';
    }

    /**
     * 获取分类的list
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
