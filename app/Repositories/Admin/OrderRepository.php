<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\Order';
    }

}
