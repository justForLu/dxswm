<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\Admin\LogRepository;
use App\Repositories\Admin\Criteria\LogCriteria;
use Illuminate\Support\Facades\Config;

class LogController extends BaseController
{
    /**
     * @var LogRepository
     */
    protected $log;

    public function __construct(LogRepository $log)
    {
        parent::__construct();

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

        $this->log->pushCriteria(new LogCriteria($params));

        $list = $this->log->with(array('manager'))->paginate(Config::get('admin.page_size',10));

        if($list){
            foreach ($list as &$v){
                $v->username = $v->manager->username ?? '';
                $v->create_time = date('Y-m-d H:i:s',$v->create_time);
            }
        }

        return view('admin.log.index',compact('params','list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
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
     * @param  int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
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
        //
    }
}
