<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Node;

class IndexController extends Controller
{
    // 后台首页显示
    public function index() {
        // 获取用户对应的权限
        $auth = session('admin.auth');
        // 读取菜单
        $menuData = (new Node())->treeData($auth);
        // 指定模板 视图
        return view('admin.index.index',compact('menuData'));
    }
    // 欢迎页面
    public function welcome() {
        return view('admin.index.welcome');
    }
    // 退出
    public function logout() {
        // 用户退出 清空session
        auth()->logout();
        // 跳转 带提示  闪存 session
        return redirect(route('admin.login'))->with('success','请重新登录');
    }
    /**
     * 测试方法
     */
    public function test(){
        dd(range(1,10));
    }
}
