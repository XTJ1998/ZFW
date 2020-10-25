<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FangRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    // 验证规则
    public function rules() {
        return [
            'fang_name' => 'required',
            'fang_province' => 'numeric|min:1',
            'fang_city' => 'numeric|min:1',
            'fang_region' => 'numeric|min:1'
        ];
    }

    // 验证提示
    public function messages() {
        return [
            'fang_province.min' => '必须选择省份'
        ];
    }
}
