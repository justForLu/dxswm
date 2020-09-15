<?php

namespace App\Repositories\Admin;

use App\Enums\BasicEnum;
use App\Repositories\BaseRepository;

class SalesmanRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\Salesman';
    }

    public function getList($where = [])
    {
        $list = $this->model->where($where)
            ->where('status',BasicEnum::ACTIVE)
            ->get()->toArray();

        return $list;
    }

}
