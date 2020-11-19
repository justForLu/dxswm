<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Api\EvaluateRepository as Evaluate;
use Illuminate\Http\Request;

class EvaluateController extends BaseController
{

    protected $evaluate;

    public function __construct(Evaluate $evaluate)
    {
        parent::__construct();

        $this->evaluate = $evaluate;

    }

}




