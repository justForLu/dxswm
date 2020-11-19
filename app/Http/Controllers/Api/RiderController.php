<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Api\RiderRepository as Rider;
use Illuminate\Http\Request;

class RiderController extends BaseController
{

    protected $rider;

    public function __construct(Rider $rider)
    {
        parent::__construct();

        $this->rider;

    }

}




