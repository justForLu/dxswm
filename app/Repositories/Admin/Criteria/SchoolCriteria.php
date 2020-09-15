<?php

namespace App\Repositories\Admin\Criteria;

use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;

class SchoolCriteria extends Criteria {

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

        if(isset($this->conditions['name']) && !empty($this->conditions['name'])){
            $model = $model->where('name', 'like','%' . $this->conditions['name'] . '%');
        }

        if(isset($this->conditions['province']) && $this->conditions['province'] > 0){
            $model = $model->where('province', $this->conditions['province']);
        }

        if(isset($this->conditions['city']) && $this->conditions['city'] > 0){
            $model = $model->where('city', $this->conditions['city']);
        }

        if(isset($this->conditions['area']) && $this->conditions['area'] > 0){
            $model = $model->where('area', $this->conditions['area']);
        }

        if(isset($this->conditions['status']) && !empty($this->conditions['status'])){
            $model = $model->where('status', $this->conditions['status']);
        }

        return $model;
    }
}
