<?php

namespace App\Repositories\Admin;


use App\Repositories\BaseRepository;

class ModuleRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Admin\Module';
    }

}
