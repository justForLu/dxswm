<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Api\SalesmanRepository as Salesman;
use Illuminate\Http\Request;

class SalesmanController extends BaseController
{

    protected $salesman;

    public function __construct(Salesman $salesman)
    {
        parent::__construct();

        $this->salesman = $salesman;

    }

}




