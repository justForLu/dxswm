<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;

class BusinessRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\Business';
    }

}
