<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BoolEnum;
use App\Enums\GoodsEnum;
use App\Enums\ManagerTypeEnum;
use App\Http\Requests\Admin\GoodsRequest;
use App\Models\Common\Business;
use App\Repositories\Admin\Criteria\GoodsCriteria;
use App\Repositories\Admin\GoodsRepository as Goods;
use App\Repositories\Admin\CategoryRepository as Category;
use App\Repositories\Admin\LogRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class GoodsController extends BaseController
{
    /**
     * @var Goods
     */
    protected $goods;
    protected $category;
    protected $log;

    public function __construct(Goods $goods, Category $category, LogRepository $log)
    {
        parent::__construct();

        $this->goods = $goods;
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

        $business_id = session('business_id');
        $params['business_id'] = $business_id;

        $this->goods->pushCriteria(new GoodsCriteria($params));

        $list = $this->goods->paginate(Config::get('admin.page_size',10));

        //店家的分类
        $category = [];
        if($business_id){
            $select = ['id','name'];
            $whereB['business_id'] = $business_id;

            $category = $this->category->getList($whereB, $select);
            $category = set_index($category,'id');
        }
        if($list){
            foreach ($list as &$v){
                $v['category_name'] = isset($category[$v['category_id']]) ? $category[$v['category_id']]['name'] : '';
            }
        }

        return view('admin.goods.index',compact('params','list','business_id','category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //店家的分类
        $business_id = session('business_id');
        $category = [];
        if($business_id){
            $select = ['id','name'];
            $whereB['business_id'] = $business_id;

            $category = $this->category->getList($whereB, $select);
        }

        return view('admin.goods.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GoodsRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Bosnadev\Repositories\Exceptions\RepositoryException
     */
    public function store(GoodsRequest $request)
    {
        $params = $request->all();
        $business_id = session('business_id');
        if(!$business_id){
            return $this->ajaxError('只要店家管理员才能创建商品');
        }
        //处理封面图片链接地址，存储封面图片链接
        $image_path = array_values(FileController::getFilePath($params['image']));
        $image_path = $image_path[0] ?? '';

        $data = [
            'business_id' => $business_id,
            'name' => $params['name'] ?? '',
            'category_id' => $params['category_id'] ?? 0,
            'image' => $image_path,
            'old_price' => $params['old_price'] ?? 0,
            'price' => $params['price'] ?? 0,
            'describe' => $params['describe'] ?? '',
            'sort' => $params['sort'] ?? 0,
            'is_recommend' => $params['is_recommend'] ?? BoolEnum::NO,
            'status' => $params['status'] ?? GoodsEnum::ONSALE,
            'create_time' => time()
        ];

        $result = $this->goods->create($data);
        $this->log->writeOperateLog($request,'添加商品');   //日志记录

        return $this->ajaxAuto($result,'添加',url('admin/goods'));
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
        $data = $this->goods->find($id);
        //店家的分类
        $business_id = session('business_id');
        $category = [];
        if($business_id){
            $select = ['id','name'];
            $whereB['business_id'] = $business_id;

            $category = $this->category->getList($whereB, $select);
        }

        return view('admin.goods.edit',compact('data','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GoodsRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(GoodsRequest $request, $id)
    {
        $params = $request->filterAll();
        //处理封面链接地址，存储封面链接
        if(strlen($params['image']) > 20){
            $image_path = $params['image'];
        }else{
            $image_path = array_values(FileController::getFilePath($params['image']));
            $image_path = $image_path[0] ?? '';
        }

        $data = [
            'name' => $params['name'] ?? '',
            'category_id' => $params['category_id'] ?? 0,
            'image' => $image_path,
            'old_price' => $params['old_price'] ?? 0,
            'price' => $params['price'] ?? 0,
            'describe' => $params['describe'] ?? '',
            'sort' => $params['sort'] ?? 0,
            'is_recommend' => $params['is_recommend'] ?? BoolEnum::NO,
            'status' => $params['status'] ?? GoodsEnum::ONSALE,
            'update_time' => time()
        ];

        $result = $this->goods->update($data,$id);
        $this->log->writeOperateLog($request,'编辑商品'); //日志记录

        return $this->ajaxAuto($result,'编辑',url('admin/goods'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->goods->delete($id);

        return $this->ajaxAuto($result,'删除');
    }
}
