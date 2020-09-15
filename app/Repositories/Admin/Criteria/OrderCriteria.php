<?php

namespace App\Repositories\Admin\Criteria;

use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;

class OrderCriteria extends Criteria {

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

        if(isset($this->conditions['order_code']) && !empty($this->conditions['order_code'])){
            $model = $model->where('order_code', $this->conditions['order_code']);
        }

        if(isset($this->conditions['business_id']) && !empty($this->conditions['business_id'])){
            $model = $model->where('business_id', $this->conditions['business_id']);
        }

        if(isset($this->conditions['user_id']) && !empty($this->conditions['user_id'])){
            $model = $model->where('user_id', $this->conditions['user_id']);
        }

        if(isset($this->conditions['mobile']) && !empty($this->conditions['mobile'])){
            $model = $model->where('mobile', $this->conditions['mobile']);
        }

        if(isset($this->conditions['user_name']) && !empty($this->conditions['user_name'])){
            $model = $model->where('user_name', 'LIKE', '%'.$this->conditions['user_name'].'%');
        }

        if(isset($this->conditions['status']) && !empty($this->conditions['status'])){
            $model = $model->where('status', $this->conditions['status']);
        }

        return $model;
    }
}
