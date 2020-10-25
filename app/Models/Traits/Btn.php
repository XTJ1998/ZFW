<?php
// 按钮

namespace App\Models\Traits;

trait Btn {
    /**
     * @param string $route 路由名
     * @return string
     */
    public function editBtn(string $route) { // {{ route('admin.user.edit',$item) }}

        if (auth()->user()->username != config('rbac.super') && !in_array($route, request()->auths)) {
           return '';
        }
        return '<a href="'.route($route,$this).'" class="label label-secondary radius">修改</a>';
    }
    /**
     * @param string $route 路由名
     * @return string
     */
    public function deleteBtn(string $route) { // {{ route('admin.user.edit',$item) }}

        if (auth()->user()->username != config('rbac.super') && !in_array($route, request()->auths)) {
            return '';
        }
        return '<a href="'.route($route,$this).'" class="label label-danger radius">删除</a>';
    }
}
