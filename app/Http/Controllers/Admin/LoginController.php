<?php
// 后台登录
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller {

    // 构造方法
    public function __construct() {
        //$this->middleware(['ckadmin:login']);
    }

    // 登录显示
    public function index(Request $request) {
        // 判断用户是否已经登录过
        if (auth()->check()) {
            // 跳转到后页
            return redirect(route('admin.index'));
        }

        return view('admin.login.login');
    }

    // 登录 别名 admin.login 根据别名生成url  route(别名);
    public function login(Request $request) {
        // 表单验证
        $post = $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => '账号都不写，想飞吗？'
        ]);

        // 登录
        $bool = auth()->attempt($post);
        // 判断是否登录成功
        if ($bool) { // 登录成功
            // auth()->user() 返回当前登录的用户模型对象 存储在session中
            // laravel默认session是存储在文件中 优化到memcached redis
            /*$model = auth()->user();
            dump($model->toArray());*/

            // 得到它权限
            // 判断一下是否是超级管理员
            if (config('rbac.super') != $post['username']) {
                $userModel = auth()->user();
                $roleModel = $userModel->role;
                $nodeArr = $roleModel->nodes()->pluck('route_name', 'id')->toArray();
                // 权限保持到session中
                session(['admin.auth' => $nodeArr]);
            } else {
                session(['admin.auth' => true]);
            }
            //return '跳转到后页';
            return redirect(route('admin.index'));
        }
        // withErrors 把信息写入到验证错误提示中  特殊的session laravel中叫 闪存
        // 闪存 从设置好之后，只能在第1个http请求中获取到数据，以后就没有了
        return redirect(route('admin.login'))->withErrors(['error' => '登录失败']);
    }

}
