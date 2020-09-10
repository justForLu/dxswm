<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;

class FeedbackRepository extends BaseRepository
{
    public function model()
    {
        return 'App\Models\Admin\Feedback';
    }

}