<?php
namespace App\Repositories\Admin\Criteria;


use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;

class ManagerCriteria extends Criteria {

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
        if(isset($this->conditions['username']) && !empty($this->conditions['username'])){
            $model = $model->where('username', 'like','%' . $this->conditions['username'] . '%');
        }

        if(isset($this->conditions['parent']) && !empty($this->conditions['parent'])){
            $model = $model->where('parent', $this->conditions['parent'])->orWhere(function ($query) {
                $query->where('id', $this->conditions['parent']);
            });
        }

        return $model;
    }
}