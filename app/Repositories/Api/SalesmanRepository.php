<?php

namespace App\Repositories\Api;

use App\Repositories\BaseRepository;

class SalesmanRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\Salesman';
    }

}
