<?php
namespace App\Repositories\Admin\Criteria;


use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;

class MenuCriteria extends Criteria {

    private $conditions;

    public function __construct($conditions){
        $this->conditions = $conditions;
    }

    /**
     * @param $model
     * @param Repository $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        if(isset($this->conditions['module']) && !empty($this->conditions['module'])){
            $model = $model->where('module', $this->conditions['module']);
        }

        if(isset($this->conditions['name'])){
            $model = $model->where('name', 'like','%' . $this->conditions['name'] . '%');
        }

        if(isset($this->conditions['grade']) && !empty($this->conditions['grade'])){
            if(is_array($this->conditions['grade'])){
                $model = $model->where('grade', $this->conditions['grade'][0],$this->conditions['grade'][1]);
            }else{
                $model = $model->where('grade', $this->conditions['grade']);
            }
        }

        if(isset($this->conditions['path']) && !empty($this->conditions['path'])){
            $model = $model->where('path', 'like','%' . $this->conditions['path'] . '%');
        }

        if(isset($this->conditions['sort']) && !empty($this->conditions['sort'])){
            $model = $model->orderBy('sort',$this->conditions['sort']);
        }else{
            $model = $model->orderBy('sort','ASC');
        }

        if(isset($this->conditions['is_system'])){
            $model = $model->where('is_system', $this->conditions['is_system']);
        }

        if(isset($this->conditions['menu_ids']) && count($this->conditions['menu_ids'])){
            $model = $model->whereIn('id', $this->conditions['menu_ids']);
        }

        return $model;
    }
}