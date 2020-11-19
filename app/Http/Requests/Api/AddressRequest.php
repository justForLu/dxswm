<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Request;

class AddressRequest extends Request
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
            'mobile' => 'required',
            'school_id' => 'required',
            'address' => 'required'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return  [
            'name.required' => '请填写联系人',
            'mobile.required' => '请填写手机号',
            'school_id.required' => '请选择高校',
            'address.required' => '请填写地址',
        ];
    }

}
