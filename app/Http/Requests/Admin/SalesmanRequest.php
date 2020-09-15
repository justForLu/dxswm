<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class SalesmanRequest extends Request
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
            'name' => 'required|unique:salesman,name,'.$this->id.'id',
            'mobile' => 'required',
            'weixin' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return  [
            'name.required' => '请填写业务员姓名',
            'name.unique' => '业务员姓名不能重复',
            'mobile.required' => '请填写业务员手机号',
            'weixin.required' => '请填写业务员微信号',
        ];
    }

}
