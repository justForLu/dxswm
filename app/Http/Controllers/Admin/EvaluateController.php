<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\EvaluateRequest;
use App\Repositories\Admin\Criteria\EvaluateCriteria;
use App\Repositories\Admin\EvaluateRepository as Evaluate;
use App\Repositories\Admin\LogRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class EvaluateController extends BaseController
{
    /**
     * @var Evaluate
     */
    protected $evaluate;
    protected $log;

    public function __construct(Evaluate $evaluate, LogRepository $log)
    {
        parent::__construct();

        $this->evaluate = $evaluate;
        $this->log = $log;
    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();

        $this->evaluate->pushCriteria(new EvaluateCriteria($params));

        $list = $this->evaluate->paginate(Config::get('admin.page_size',10));

        return view('admin.evaluate.index',compact('params','list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EvaluateRequest $request
     */
    public function store(EvaluateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @param Request $request
     */
    public function edit($id,Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EvaluateRequest $request
     * @param $id
     */
    public function update(EvaluateRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->evaluate->delete($id);

        return $this->ajaxAuto($result,'删除');
    }

}
