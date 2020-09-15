<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BasicEnum;
use App\Enums\ManagerTypeEnum;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Common\Business;
use App\Repositories\Admin\Criteria\CategoryCriteria;
use App\Repositories\Admin\CategoryRepository as Category;
use App\Repositories\Admin\LogRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    /**
     * @var Category
     */
    protected $category;
    protected $log;

    public function __construct(Category $category, LogRepository $log)
    {
        parent::__construct();

        $this->category = $category;
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

        $this->category->pushCriteria(new CategoryCriteria($params));

        $list = $this->category->paginate(Config::get('admin.page_size',10));

        if($list){
            //处理店铺
            $business_ids = [];
            foreach ($list as $value){
                $business_ids[] = $value['business_id'];
            }
            $business_ids = array_unique($business_ids);
            $business_list = [];
            if($business_ids){
                $business_list = Business::whereIn('id',$business_ids)->pluck('name','id');
            }
            foreach ($list as &$v){
                $v['business_name'] = isset($business_list[$v['business_id']]) ? $business_list[$v['business_id']] : $v['business_id'];
            }
        }

        return view('admin.category.index',compact('params','list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Bosnadev\Repositories\Exceptions\RepositoryException
     */
    public function store(CategoryRequest $request)
    {
        $params = $request->all();

        $manager_type = Auth::user()->type;
        if($manager_type != ManagerTypeEnum::BUSINESS){
            return $this->ajaxError('只有店家管理员才能创建分类');
        }
        $business_id = session('business_id');

        $data = [
            'business_id' => $business_id,
            'type' => $params['type'] ?? 0,
            'pid' => $params['pid'] ?? 0,
            'name' => $params['name'] ?? '',
            'sort' => $params['sort'] ?? 0,
            'status' => $params['status'] ?? BasicEnum::ACTIVE,
            'create_time' => time()
        ];

        $result = $this->category->create($data);
        $this->log->writeOperateLog($request,'新增分类');   //日志记录

        return $this->ajaxAuto($result,'添加',url('admin/category'));
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
        $data = $this->category->find($id);

        return view('admin.category.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryRequest $request, $id)
    {
        $params = $request->filterAll();

        $data = [
            'type' => $params['type'] ?? 0,
            'pid' => $params['pid'] ?? 0,
            'name' => $params['name'] ?? '',
            'sort' => $params['sort'] ?? 0,
            'status' => $params['status'] ?? BasicEnum::ACTIVE,
            'update_time' => time()
        ];

        $result = $this->category->update($data,$id);
        $this->log->writeOperateLog($request,'编辑分类'); //日志记录

        return $this->ajaxAuto($result,'修改',url('admin/category'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->category->delete($id);

        return $this->ajaxAuto($result,'删除');
    }

    /**
     * 获取分类list
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategory($type)
    {
        $data = $this->category->getCategoryList($type);

        return $this->ajaxSuccess($data,'OK');
    }
}
