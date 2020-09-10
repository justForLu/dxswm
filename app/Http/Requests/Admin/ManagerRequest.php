<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class ManagerRequest extends Request
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
                'role_id' => 'required'
            ];
        }else{
            return [
                'username' => 'required|unique:manager,username,'.$this->id.'id',
                'role_id' => 'required'
            ];
        }

    }

    /**
     * @return array
     */
    public function messages()
    {
        return  [
            'username.required' => '用户名必填',
            'username.unique' => '用户名不能重复',
            'password.required' => '密码必填',
            'role_id.required' => '角色必选'
        ];
    }

}
