<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ConfigRequest;
use App\Repositories\Admin\ConfigRepository;
use App\Repositories\Admin\LogRepository;

class ConfigController extends BaseController
{
    /**
     * @var ConfigRepository
     */
    protected $config;
    protected $log;

    public function __construct(ConfigRepository $config, LogRepository $log)
    {
        parent::__construct();

        $this->config = $config;
        $this->log = $log;
    }
    /**
     * Display a listing of the resource.
     *
     * @param ConfigRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(ConfigRequest $request)
    {
        $data = $this->config->getConfig();

        return view('admin.config.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param ConfigRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(ConfigRequest $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ConfigRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ConfigRequest $request)
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
     * @param ConfigRequest $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id,ConfigRequest $request)
    {
        $data = $this->config->find($id);

        return view('admin.config.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ConfigRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ConfigRequest $request, $id)
    {
        $params = $request->all();

        $data = [
            'title' => $params['title'] ?? '',
            'copyright' => $params['copyright'] ?? ''
        ];

        $result = $this->config->update($data,$id);
        $this->log->writeOperateLog($request,'编辑网站配置'); //日志记录

        return $this->ajaxAuto($result,'修改',url('admin/config'));
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
