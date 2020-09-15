<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BasicEnum;
use App\Http\Requests\Admin\UserRequest;
use App\Repositories\Admin\Criteria\UserCriteria;
use App\Repositories\Admin\UserRepository as User;
use App\Repositories\Admin\LogRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * @var User
     */
    protected $user;
    protected $log;

    public function __construct(User $user, LogRepository $log)
    {
        parent::__construct();

        $this->user = $user;
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

        $this->user->pushCriteria(new UserCriteria($params));

        $list = $this->user->paginate(Config::get('admin.page_size',10));
        if($list){
            foreach ($list as &$v){
                $v['login_time'] = date('Y-m-d H:i:s', $v['login_time']);
            }
        }

        return view('admin.user.index',compact('params','list'));
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
     * @param UserRequest $request
     */
    public function store(UserRequest $request)
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
        $data = $this->user->find($id);

        return view('admin.user.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, $id)
    {
        $params = $request->filterAll();

        $data = [
            'status' => $params['status'] ?? BasicEnum::ACTIVE,
            'update_time' => time()
        ];

        $result = $this->user->update($data,$id);
        $this->log->writeOperateLog($request,'修改用户'); //日志记录

        return $this->ajaxAuto($result,'修改',url('admin/user'));
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
