<?php

namespace App\Repositories\Api;

use App\Repositories\BaseRepository;

class ApplyRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\Apply';
    }

}
