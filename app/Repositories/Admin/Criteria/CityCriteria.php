<?php
namespace App\Repositories\Admin\Criteria;

use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;

class CityCriteria extends Criteria {

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
        if(isset($this->conditions['parent']) && !empty($this->conditions['parent'])){
            $model = $model->where('parent', '=', $this->conditions['parent']);
        }else{
            $model = $model->where('parent', '=', 0);
        }

        if(isset($this->conditions['title']) && !empty($this->conditions['title'])){
            $model = $model->where('title', 'like', '%' . $this->conditions['title'] . '%');
        }

        $model = $model->orderBy('id','ASC');

        return $model;
    }
}
