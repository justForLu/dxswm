<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Api\SchoolRepository as School;
use Illuminate\Http\Request;

class SchoolController extends BaseController
{

    protected $school;

    public function __construct(School $school)
    {
        parent::__construct();

        $this->school = $school;

    }


    /**
     * 获取高校列表
     * @param Request $request
     * @return mixed
     */
    public function getList(Request $request)
    {
        $params = $request->all();

        $list = $this->school->getList($params);

        return $this->ajaxSuccess($list,'OK');
    }

}




