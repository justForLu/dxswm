<?php

namespace App\Repositories\Admin;


use App\Repositories\BaseRepository;

class RoleRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Admin\Role';
    }

}
