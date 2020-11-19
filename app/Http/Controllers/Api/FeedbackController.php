<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Api\FeedbackRepository as Feedback;
use Illuminate\Http\Request;

class FeedbackController extends BaseController
{

    protected $feedback;

    public function __construct(Feedback $feedback)
    {
        parent::__construct();

        $this->feedback = $feedback;

    }

}




