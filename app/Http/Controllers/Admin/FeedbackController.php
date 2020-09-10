<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\FeedbackRequest;
use App\Repositories\Admin\Criteria\FeedbackCriteria;
use App\Repositories\Admin\FeedbackRepository as Feedback;
use App\Repositories\Admin\LogRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class FeedbackController extends BaseController
{
    /**
     * @var Feedback
     */
    protected $feedback;
    protected $log;

    public function __construct(Feedback $feedback, LogRepository $log)
    {
        parent::__construct();

        $this->feedback = $feedback;
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

        $this->feedback->pushCriteria(new FeedbackCriteria($params));

        $list = $this->feedback->paginate(Config::get('admin.page_size',10));

        return view('admin.feedback.index',compact('params','list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param FeedbackRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(FeedbackRequest $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FeedbackRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FeedbackRequest $request)
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
        $params = $request->all();
        $params['id'] = $id;

        $data = $this->feedback->find($id);

        return view('admin.feedback.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FeedbackRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FeedbackRequest $request, $id)
    {
        $params = $request->filterAll();
        $userInfo = Auth::user();

        $data = [
            'status' => $params['status'] ?? 1,
            'remark' => $params['remark'] ?? '',
            'admin_id' => $userInfo->id,
            'admin_name' => $userInfo->username,
            'update_time' => time()
        ];

        $result = $this->feedback->update($data,$id);
        $this->log->writeOperateLog($request,'编辑意见反馈'); //日志记录

        return $this->ajaxAuto($result,'修改',url('admin/feedback'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->feedback->delete($id);

        return $this->ajaxAuto($result,'删除');
    }
}
