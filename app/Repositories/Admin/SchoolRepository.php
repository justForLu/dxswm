<?php

namespace App\Repositories\Admin;

use App\Enums\BasicEnum;
use App\Repositories\BaseRepository;

class SchoolRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\School';
    }

    public function getList($where = [], $select = '*')
    {
        $list = $this->model->select($select)
            ->where($where)
            ->where('status',BasicEnum::ACTIVE)
            ->get()->toArray();

        return $list;
    }
}
