<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class GoodsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'category_id' => 'required',
            'image' => 'required',
            'price' => 'required'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return  [
            'name.required' => '请填写商品名称',
            'category_id.required' => '请填写选择分类',
            'image.required' => '请填写上传图片',
            'price.required' => '请填写商品价格',
        ];
    }

}
