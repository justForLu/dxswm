<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class Request extends FormRequest
{
    /**
     * 过滤请求输入内容
     * @param array $filter
     * @return array
     */
    public function filterAll($filter = array())
    {
        return $this->except(array_merge(['_token','_method'],$filter));
    }

    /**
     * 重写错误返回
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($this->formatErrors($validator)));
    }
    /**
     * 重新定义验证失败响应信息
     * @param Validator $validator
     * @return array
     */
    public function formatErrors(Validator $validator){
        $ajaxData = array();

        $ajaxData['status'] = 'fail';
        $ajaxData['code'] = 300;
        $ajaxData['msg'] = $validator->errors()->first();

        return $ajaxData;
    }

    /**
     * 重新定义验证失败响应码
     * @param array $errors
     * @return $this|JsonResponse
     */
    public function response(array $errors)
    {
        if (($this->ajax() && ! $this->pjax()) || $this->wantsJson()) {
            return new JsonResponse($errors, 300);
        }

        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag);
    }
}
