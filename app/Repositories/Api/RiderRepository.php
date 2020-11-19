<?php

namespace App\Repositories\Api;

use App\Repositories\BaseRepository;

class RiderRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\Rider';
    }

}
