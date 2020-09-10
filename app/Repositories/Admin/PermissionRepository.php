<?php

namespace App\Repositories\Admin;


use App\Repositories\BaseRepository;

class PermissionRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Admin\Permission';
    }

}
