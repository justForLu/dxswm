<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;

class GoodsRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\Goods';
    }

}
