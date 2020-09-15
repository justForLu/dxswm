<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class BusinessRequest extends Request
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
        if($this->method() != 'PUT'){
            return [
                'username' => 'required|unique:manager,username,'.$this->id.'id',
                'password' => 'required',
                're_password' => 'required',
                'name' => 'required|unique:business,name,'.$this->id.'id',
                'mobile' => 'required',
                'image' => 'required',
                'province' => 'required',
                'city' => 'required',
                'area' => 'required',
                'school' => 'required',
                'time_limit' => 'required'
            ];
        }else{
            return [
                'name' => 'required|unique:business,name,'.$this->id.'id',
                'mobile' => 'required',
                'image' => 'required',
                'province' => 'required',
                'city' => 'required',
                'area' => 'required',
                'school' => 'required',
                'time_limit' => 'required'
            ];
        }
    }

    /**
     * @return array
     */
    public function messages()
    {
        return  [
            'username.required' => '请填写店家管理员账号',
            'username.unique' => '店家管理员账号不能重复',
            'password.required' => '请填写店家管理员密码',
            're_password.required' => '请再次填写店家管理员密码',
            'name.required' => '请填写店家名称',
            'name.unique' => '店家名称不能重复',
            'mobile.required' => '请填写店家手机号',
            'image.required' => '请上传店铺封面',
            'province.required' => '请选择省份',
            'city.required' => '请选择城市',
            'area.required' => '请选择区/县',
            'school.required' => '请选择高校',
            'time_limit.required' => '请填写经营时间范围',
        ];
    }

}
