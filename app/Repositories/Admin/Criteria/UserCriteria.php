<?php

namespace App\Repositories\Admin\Criteria;

use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;

class UserCriteria extends Criteria {

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

        if(isset($this->conditions['nickname']) && !empty($this->conditions['nickname'])){
            $model = $model->where('nickname', 'like','%' . $this->conditions['nickname'] . '%');
        }

        if(isset($this->conditions['mobile']) && !empty($this->conditions['mobile'])){
            $model = $model->where('mobile', $this->conditions['mobile']);
        }

        if(isset($this->conditions['is_business']) && $this->conditions['is_business'] >= 0){
            $model = $model->where('is_business', $this->conditions['is_business']);
        }

        if(isset($this->conditions['is_rider']) && $this->conditions['is_rider'] >= 0){
            $model = $model->where('is_rider', $this->conditions['is_rider']);
        }

        if(isset($this->conditions['status']) && !empty($this->conditions['status'])){
            $model = $model->where('status', $this->conditions['status']);
        }

        return $model;
    }
}
