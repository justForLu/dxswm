<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class SchoolRequest extends Request
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
            'name' => 'required|unique:school,name,'.$this->id.'id',
            'province' => 'required',
            'city' => 'required',
            'area' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return  [
            'name.required' => '请填写高校名称',
            'name.unique' => '高校名称不能重复',
            'province.required' => '请选择省份',
            'city.required' => '请选择城市',
            'area.required' => '请选择县/区',
        ];
    }

}
