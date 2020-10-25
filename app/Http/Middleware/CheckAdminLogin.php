<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdminLogin {
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $param 中间件传参  在绑定中间件地方 :值
     * @return mixed
     */
    public function handle($request, Closure $next) {

        // 用户是否登录检查
        if (!auth()->check()) {
            return redirect(route('admin.login'))->withErrors(['error' => '请登录']);
        }

        // 访问的权限
        $auths = is_array(session('admin.auth')) ? array_filter(session('admin.auth')) : [];
        $auths = array_merge($auths, config('rbac.allow_route'));

        // 当前访问的路由
        $currentRoute = $request->route()->getName();
        // 权限判断
        if (auth()->user()->username != config('rbac.super') && !in_array($currentRoute, $auths)) {
            exit('你没有权限');
        }

        // 使用request传到下级去
        $request->auths = $auths;


        // 如果没有停止则向后执行
        return $next($request);
    }
}
