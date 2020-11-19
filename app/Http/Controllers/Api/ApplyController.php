<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Api\ApplyRepository as Apply;
use Illuminate\Http\Request;

class ApplyController extends BaseController
{

    protected $apply;

    public function __construct(Apply $apply)
    {
        parent::__construct();

        $this->apply = $apply;

    }

}




