<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ApplyRequest;
use App\Repositories\Admin\Criteria\ApplyCriteria;
use App\Repositories\Admin\ApplyRepository as Apply;
use App\Repositories\Admin\LogRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class ApplyController extends BaseController
{
    /**
     * @var Apply
     */
    protected $apply;
    protected $log;

    public function __construct(Apply $apply, LogRepository $log)
    {
        parent::__construct();

        $this->apply = $apply;
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

        $this->apply->pushCriteria(new ApplyCriteria($params));

        $list = $this->apply->with(array('user','salesman','manager'))->paginate(Config::get('admin.page_size',10));

        return view('admin.apply.index',compact('params','list'));
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
     * @param ApplyRequest $request
     */
    public function store(ApplyRequest $request)
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
        $data = $this->apply->find($id);

        return view('admin.apply.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ApplyRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ApplyRequest $request, $id)
    {
        $params = $request->filterAll();

        $data = [
            'status' => $params['status'] ?? 0,
            'refuse' => $params['refuse'] ?? '',
            'admin_id' => Auth::id(),
            'remark' => $params['remark'] ?? '',
            'update_time' => time()
        ];

        $result = $this->apply->update($data,$id);
        $this->log->writeOperateLog($request,'审核申请'); //日志记录

        return $this->ajaxAuto($result,'操作',url('admin/apply'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     */
    public function destroy($id)
    {
        //
    }

}
