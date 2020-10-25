<?php
// 房东管理
namespace App\Http\Controllers\Admin;

use App\Exports\FangOwnerExport;
use App\Models\FangOwner;
use Illuminate\Http\Request;
// excel类
use Maatwebsite\Excel\Facades\Excel;

class FangOwnerController extends BaseController {
    // 列表
    public function index() {
        // 获取用户数据
        $data = FangOwner::paginate($this->pagesize);
        // 赋值给视图模板
        return view('admin.fangowner.index', compact('data'));
    }

    // 添加显示
    public function create() {

        return view('admin.fangowner.create');
    }

    // 文件上传
    public function upfile(Request $request) {
        // 默认图标
        $pic = config('up.pic');
        if ($request->hasFile('file')) {
            // 上传
            // 参数2 配置的节点名称
            $ret = $request->file('file')->store('', 'fangowner');
            $pic = '/uploads/fangowner/' . $ret;
        }
        return ['status' => 0, 'url' => $pic];
    }

    // 文件删除
    public function delfile(Request $request) {
        $filepath = $request->get('file');
        // 得到真实的地址
        $path = public_path() . $filepath;
        // 删除指定的文件
        unlink($path);
        return ['status' => 0, 'msg' => '成功'];
    }

    // 添加房东处理
    public function store(Request $request) {
        // 表单验证
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required'
        ]);
        // 获取数据
        $postData = $request->except(['_token', 'file']);
        // 去除#
        $postData['pic'] = trim($postData['pic'], '#');

        // 入库
        FangOwner::create($postData);
        // 跳转到列表页面
        return redirect(route('admin.fangowner.index'));
    }

    // 显示图片
    public function show(FangOwner $fangowner) {
        $picList = explode('#', $fangowner->pic);
        // 遍历
        array_map(function ($item) {
            echo "<div><img src=$item  style='width: 150px;'/></div>";
        }, $picList);

        return '';
    }

    // 导出excel
    public function exports() {
        return Excel::download(new FangOwnerExport(), 'fangdong.xlsx');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\FangOwner $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function edit(FangOwner $fangowner) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\FangOwner $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FangOwner $fangowner) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\FangOwner $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function destroy(FangOwner $fangowner) {
        //
    }
}
