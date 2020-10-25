<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddArtRequest extends FormRequest {
    /**
     * 验证
     */
    public function authorize() {
        return true;
    }
    /**
     * 表单验证
     */
    public function rules() {
        return [
            'title' => 'required',
            'desn' => 'required',
            'body' => 'required'
        ];
    }
    // 自定义验证错误信息
    public function messages() {
        return [
            'title.required' => '标题一定要写'
        ];
    }
}
