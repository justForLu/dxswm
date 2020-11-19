<?php

namespace App\Repositories\Api;

use App\Repositories\BaseRepository;

class CollectRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\Collect';
    }

}
