<?php
namespace App\Repositories\Admin\Criteria;


use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;

class RoleCriteria extends Criteria {

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

        if(isset($this->conditions['parent']) && !empty($this->conditions['parent'])){
            //if(isset($this->conditions['self']) && $this->conditions['self']){
                $model = $model->where('parent', $this->conditions['parent'])->orWhere(function ($query) {
                    $query->where('id', $this->conditions['parent']);
                });
            //}else{
            //    $model = $model->where('parent', $this->conditions['parent']);
            //}

        }

        $model = $model->orderBy('id','DESC');

        return $model;
    }
}