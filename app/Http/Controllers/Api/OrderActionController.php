<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Api\OrderActionRepository as OrderAction;
use Illuminate\Http\Request;

class OrderActionController extends BaseController
{

    protected $order_action;

    public function __construct(OrderAction $order_action)
    {
        parent::__construct();

        $this->order_action = $order_action;

    }

}




