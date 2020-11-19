<?php

namespace App\Repositories\Api;

use App\Repositories\BaseRepository;

class FeedbackRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Common\Evaluate';
    }

}
