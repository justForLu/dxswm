<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BasicEnum;
use App\Http\Requests\Admin\SalesmanRequest;
use App\Repositories\Admin\Criteria\SalesmanCriteria;
use App\Repositories\Admin\SalesmanRepository as Salesman;
use App\Repositories\Admin\LogRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class SalesmanController extends BaseController
{
    /**
     * @var Salesman
     */
    protected $salesman;
    protected $log;

    public function __construct(Salesman $salesman, LogRepository $log)
    {
        parent::__construct();

        $this->salesman = $salesman;
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

        $this->salesman->pushCriteria(new SalesmanCriteria($params));

        $list = $this->salesman->paginate(Config::get('admin.page_size',10));

        return view('admin.salesman.index',compact('params','list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.salesman.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SalesmanRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Bosnadev\Repositories\Exceptions\RepositoryException
     */
    public function store(SalesmanRequest $request)
    {
        $params = $request->all();

        $data = [
            'name' => $params['name'] ?? '',
            'mobile' => $params['mobile'] ?? '',
            'weixin' => $params['weixin'] ?? '',
            'status' => $params['status'] ?? BasicEnum::ACTIVE,
            'create_time' => time()
        ];

        $result = $this->salesman->create($data);
        $this->log->writeOperateLog($request,'添加业务员');   //日志记录

        return $this->ajaxAuto($result,'添加',url('admin/salesman'));
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
        $data = $this->salesman->find($id);

        return view('admin.salesman.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SalesmanRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SalesmanRequest $request, $id)
    {
        $params = $request->filterAll();

        $data = [
            'name' => $params['name'] ?? '',
            'mobile' => $params['mobile'] ?? '',
            'weixin' => $params['weixin'] ?? '',
            'status' => $params['status'] ?? BasicEnum::ACTIVE,
            'update_time' => time()
        ];

        $result = $this->salesman->update($data,$id);
        $this->log->writeOperateLog($request,'编辑业务员'); //日志记录

        return $this->ajaxAuto($result,'修改',url('admin/salesman'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->salesman->delete($id);

        return $this->ajaxAuto($result,'删除');
    }

}
