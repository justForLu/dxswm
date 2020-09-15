<?php

namespace App\Repositories\Admin\Criteria;

use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;

class ApplyCriteria extends Criteria {

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

        if(isset($this->conditions['user_id']) && !empty($this->conditions['user_id'])){
            $model = $model->where('user_id', $this->conditions['user_id']);
        }

        if(isset($this->conditions['salesman_id']) && !empty($this->conditions['salesman_id'])){
            $model = $model->where('salesman_id', $this->conditions['salesman_id']);
        }

        if(isset($this->conditions['admin_id']) && !empty($this->conditions['admin_id'])){
            $model = $model->where('admin_id', $this->conditions['admin_id']);
        }

        if(isset($this->conditions['type']) && !empty($this->conditions['type'])){
            $model = $model->where('type', $this->conditions['type']);
        }

        if(isset($this->conditions['status']) && !empty($this->conditions['status'])){
            $model = $model->where('status', $this->conditions['status']);
        }

        return $model;
    }
}
