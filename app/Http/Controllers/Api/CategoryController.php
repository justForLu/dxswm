<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Api\CategoryRepository as Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class CategoryController extends BaseController
{

    protected $category;

    public function __construct(Category $category)
    {
        parent::__construct();

        $this->category = $category;

    }

    /**
     * 分类列表
     * @param Request $request
     * @return mixed
     */
    public function getList(Request $request)
    {
        $params = $request->all();
        $school_id = Cache::get(Config::get('api.school_id_key'));
        $school_id = $school_id ? $school_id : Config::get('api.default_school_id');
        $params['school_id'] = $school_id;

        $list = $this->category->getList($params);

        return $this->ajaxSuccess($list,'OK');
    }


    /**
     * 根据店家ID获取分类列表以及其下的商品
     * @param Request $request
     * @return mixed
     */
    public function getCatGoods(Request $request)
    {
        $params = $request->all();
        //判断店家ID
        if(!isset($params['business_id']) || empty($params['business_id'])){
            return $this->ajaxError('未知错误');
        }
        $params['user_id'] = 1;

        $list = $this->category->getCatGoods($params);

        return $this->ajaxSuccess($list,'OK');
    }

}




