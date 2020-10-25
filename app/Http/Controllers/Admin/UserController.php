<?php
// 后台用户管理
namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Mail\Message;
use Mail;
// 密码加密的明文是否是对应的
use Hash;

class UserController extends BaseController {

    // 用户列表
    public function index() {
        // 分页  withTrashed 显示所有的，包括已经进行了软删除的
        $data = User::orderBy('id', 'asc')->withTrashed()->paginate($this->pagesize);

        return view('admin.user.index', compact('data'));
    }

    // 添加显示
    public function create() {

        return view('admin.user.create');
    }

    // 添加处理
    public function store(Request $request) {

        /*$this->validate($request, [
            'username' => 'required',
            'truename' => 'required',
            'password' => 'required|confirmed',
            'phone' => 'nullable|phone'
        ], [
            'phone.phone' => '手机号码不合法'
        ]);*/
        $this->validate($request, [
            // 用户名唯一性验证
            'username' => 'required|unique:users,username',
            'truename' => 'required',
            // 两次密码是否一致的验证
            'password' => 'required|confirmed',
            // 自定义验证规则
            'phone' => 'nullable|phone'
        ]);

        // 获取表单数据
        $post = $request->except(['_token', 'password_confirmation']);
        // 添回味用户入库
        $userModel = User::create($post);

        // 密码
        $pwd = $post['password'];

        // 发邮件给用户
        Mail::send('mail.useradd',compact('userModel','pwd'),function (Message $message) use ($userModel){
            // 发给谁
            $message->to($userModel->email);
            // 主题
            $message->subject('开通账号箱件通知');
        });


        // 跳转到列表页
        return redirect(route('admin.user.index'))->with('success', '添加用户成功');
    }

    // 删除用户操作
    public function del(int $id) {
        // 删除
        User::find($id)->delete();

        // 强制删除 在配置了软删除的时候，真实的删除操作
        // User::find($id)->forceDelete();

        return ['status' => 0, 'msg' => '删除成功'];
    }
    // 还原
    public function restore(int $id) {
        // 还原 只显示已删除的数据
        User::onlyTrashed()->where('id',$id)->restore();
        return redirect(route('admin.user.index'))->with('success','还原成功');
    }
    // 全选删除
    public function delall(Request $request) {
        $ids = $request->get('id');
        User::destroy($ids);

        return ['status'=>0,'msg'=>'全选删除成功'];
    }

    // 修改显示
    public function edit(int $id) {
        $model = User::find($id);

        return view('admin.user.edit',compact('model'));
    }

    // 修改处理
    public function update(Request $request,int $id) {
        $model = User::find($id);

        // 原密码  明文
        $spass = $request->get('spassword');
        // 原密码 密文
        $oldpass = $model->password;

        // 检查明文和密码是否一致
        $bool = Hash::check($spass,$oldpass);

        if($bool){
            // 修改
            $data = $request->only([
                'truename',
                'password',
                'phone',
                'sex',
                'email'
            ]);
            if(!empty($data['password'])){
                $data['password'] = bcrypt($data['password']);
            }else{
                unset($data['password']);
            }
            $model->update($data);
            return redirect(route('admin.user.index'))->with('success','修改用户成功');
        }
        return redirect(route('admin.user.edit',$model))->withErrors(['error'=>'原密不正确']);
    }

    // 分配角色和处理
    public function role(Request $request,User $user) {
        // 判断是否是post提示
        if ($request->isMethod('post')){
            $post = $this->validate($request,[
                'role_id'=>'required'
            ],['role_id.required'=>'必须选择']);

            $user->update($post);
            return redirect(route('admin.user.index'));
        }

        // 读取所有的角色
        $roleAll = Role::all();
        return view('admin.user.role',compact('user','roleAll'));
    }

}
