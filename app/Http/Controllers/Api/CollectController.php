<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Api\CollectRepository as Collect;
use Illuminate\Http\Request;

class CollectController extends BaseController
{

    protected $collect;

    public function __construct(Collect $collect)
    {
        parent::__construct();

        $this->collect = $collect;

    }

}




