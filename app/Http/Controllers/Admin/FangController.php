<?php
// 房源管理
namespace App\Http\Controllers\Admin;

use App\Http\Requests\FangRequest;
use App\Models\City;
use App\Models\Fang;
use App\Models\Fangattr;
use App\Models\FangOwner;

use Illuminate\Http\Request;
// 发起HTTP请求
use GuzzleHttp\Client;
// 导入es生成索引类
use Elasticsearch\ClientBuilder;

class FangController extends BaseController {
    // 房源列表
    public function index() {
        // 获取数据
        // with 关联关系的调用
        $data = Fang::with(['owner'])->paginate($this->pagesize);
        // 指定视图模板并赋值
        return view('admin.fang.index', compact('data'));
    }

    // 添加显示模板
    // 依赖注入  反射
    public function create(Fang $fang) {
        // 取关联表数据 方案1
        //$data = (new Fang())->relationData();
        // 方案2 依赖注入
        $data = $fang->relationData();
        return view('admin.fang.create', $data);
    }

    // 获取城市
    public function city(Request $request) {
        $data = City::where('pid', $request->get('id'))->get(['id', 'name']);
        return $data;
    }

    // 添加处理
    public function store(FangRequest $request) {
        // 表单数据
        $dopost = $request->except(['_token', 'file']);
        // 入库
        $model = Fang::create($dopost);
        // 添加数据入库成功了
        // 发起HTTP请求
        // 申明一个请求类，并指定请求的过期时间
        $client = new Client(['timeout' => 5]);
        // 得到请求地址
        $url = config('gaode.geocode');
        $url = sprintf($url, $model->fang_addr, $model->fang_province);
        // 发起请求
        $response = $client->get($url);
        $body = (string)$response->getBody();
        $arr = json_decode($body, true);
        // 如果找到了对应经纬度，存入数据表中
        if (count($arr['geocodes']) > 0) {
            $locationArr = explode(',', $arr['geocodes'][0]['location']);
            $model->update([
                'longitude' => $locationArr[0],
                'latitude' => $locationArr[1]
            ]);
        }

        // es数据的添加
        // 得到es客户端对象
        $client = ClientBuilder::create()->setHosts(config('es.host'))->build();
        // 写文档
        $params = [
            'index' => 'fang',
            'type' => '_doc',
            'id' => $model->id,
            'body' => [
                'fang_name' => $model->fang_name,
                'fang_desn' => $model->fang_desn,
            ],
        ];
        // 添加数据到索引文档中
        $client->index($params);
        // 跳转
        return redirect(route('admin.fang.index'));
    }

    // 生成房源信息索引
    public function esinit() {
        // 得到es客户端对象
        $client = ClientBuilder::create()->setHosts(config('es.host'))->build();
        // 创建索引
        $params = [
            // 生成索引的名称
            'index' => 'fang',
            // 类型 body
            'body' => [
                'settings' => [
                    // 分区数
                    'number_of_shards' => 5,
                    // 副本数
                    'number_of_replicas' => 1
                ],
                'mappings' => [
                    '_doc' => [
                        '_source' => [
                            'enabled' => true
                        ],
                        // 字段  类似表字段，设置类型
                        'properties' => [
                            'fang_name' => [
                                // 相当于数据查询是的 = 张三你好，必须找到张三你好
                                'type' => 'keyword'
                            ],
                            'fang_desn' => [
                                'type' => 'text',
                                // 中文分词  张三你好   张三  你好 张三你好
                                'analyzer' => 'ik_max_word',
                                'search_analyzer' => 'ik_max_word'
                            ]
                        ]
                    ]
                ]
            ]
        ];
        // 创建索引
        $response = $client->indices()->create($params);

        dump($response);
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Fang $fang
     * @return \Illuminate\Http\Response
     */
    public function show(Fang $fang) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Fang $fang
     * @return \Illuminate\Http\Response
     */
    public function edit(Fang $fang) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Fang $fang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fang $fang) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Fang $fang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fang $fang) {
        //
    }
}
