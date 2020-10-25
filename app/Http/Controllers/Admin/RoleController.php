<?php

namespace App\Http\Controllers\Admin;

use App\Models\Node;
use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Role;

class RoleController extends BaseController {
    /**
     * 列表
     */
    public function index(Request $request) {
        // 获取搜索框
        $name = $request->get('name', '');

        // 分页 搜索
        // 参数1， 变量值存在。则执行 参数2--->匿名函数
        $data = Role::when($name, function ($query) use ($name) {
            $query->where('name', 'like', "%{$name}%");
        })->paginate($this->pagesize);
        return view('admin.role.index', compact('data', 'name'));
    }

    /**
     * 添加显示
     */
    public function create() {

        return view('admin.role.create');
    }

    /**
     * 添加处理
     */
    public function store(Request $request) {
        // 异常处理
        try {
            $this->validate($request, [
                'name' => 'required|unique:roles,name'
            ]);
        } catch (\Exception $e) {
            return ['status' => 1000, 'msg' => '验证不通过'];
        }
        // 接受 all 接受所有的数据
        Role::create($request->only('name'));

        return ['status' => 0, 'msg' => '添加角色成功'];
    }

    /**
     * 根据ID显示对应信息
     */
    public function show($id) {
        //
    }

    /**
     * 修改显示
     */
    public function edit(int $id) {
        $model = Role::find($id);
        return view('admin.role.edit', compact('model'));
    }
    /**
     * 修改处理
     */
    public function update(Request $request, int $id) {
        // 异常处理
        try {
            $this->validate($request, [
                // unique:表名,唯一字段,[排除行的值，以那个字段来排除]
                // 排除id=3的哪行名为name的字段值
                'name' => 'required|unique:roles,name,' . $id . ',id'
            ]);
        } catch (\Exception $e) {
            return ['status' => 1000, 'msg' => '验证不通过'];
        }
        // 修改角色入库
        //Role::where('id', $id)->update($request->only(['name']));
        Role::where([['id', '=', $id]])->update($request->only(['name']));
        return ['status' => 0, 'msg' => '修改用户成功'];
    }

    // 给角色分配权限
    public function node(Role $role) {
        //dump($role->nodes->toArray());
        //dump($role->nodes()->pluck('name','id')->toArray());
        // 读取出所有的权限
        $nodeAll = (new Node())->getAllList();
        // 读取当前角色所拥有的权限
        $nodes = $role->nodes()->pluck('id')->toArray();

        return view('admin.role.node',compact('role','nodeAll','nodes'));
    }
    // 分配处理
    public function nodeSave(Request $request,Role $role) {
        // 关联模型的数据同步
        $role->nodes()->sync($request->get('node'));
        return redirect(route('admin.role.node',$role));
    }

    /**
     * 删除操作
     */
    public function destroy($id) {
        //
    }
}
