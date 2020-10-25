<?php

namespace App\Http\Controllers\Admin;

use App\Models\Node;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NodeController extends Controller {
    /**
     * 节点列表
     */
    public function index() {
        // 获取所有的节点 返回是数组
        $data =(new Node)->getAllList();
        return view('admin.node.index', compact('data'));
    }

    /**
     * 添加
     */
    public function create() {
        // 获取所有的顶部
        $data = Node::where('pid', 0)->get();
        return view('admin.node.create', compact('data'));
    }

    /**
     * 添加处理
     */
    public function store(Request $request) {
        // 表单验证
        // try() catch()
        // 入库
        /*$data = $request->except('_token');
        $data['route_name'] = empty()*/
        Node::create($request->except('_token'));
        return ['status' => 0, 'msg' => '添加权限成功'];
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Node $node
     * @return \Illuminate\Http\Response
     */
    public function show(Node $node) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Node $node
     * @return \Illuminate\Http\Response
     */
    public function edit(Node $node) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Node $node
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Node $node) {
        // find()
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Node $node
     * @return \Illuminate\Http\Response
     */
    public function destroy(Node $node) {
        //
    }
}
