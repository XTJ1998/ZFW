@extends('admin.common.main')

@section('css')
    {{-- webuploader上传样式 --}}
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css"/>
@endsection

@section('cnt')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 房源管理
        <span class="c-gray en">&gt;</span> 添加房源
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <article class="page-container">
        {{-- 表单验证提示 --}}
        @include('admin.common.validate')

        <form action="{{ route('admin.fang.store') }}" method="post" class="form form-horizontal" id="fang-add">
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>房源名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="fang_name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>小区名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="fang_xiaoqu">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>小区地址：</label>
                <div class="formControls col-xs-4 col-sm-4">
                    <select name="fang_province" style="width: 100px;" onchange="selectCity(this,'fang_city')">
                        <option value="0">==请选择省==</option>
                        @foreach($cityData as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <select name="fang_city" id="fang_city" style="width: 100px;" onchange="selectCity(this,'fang_region')">
                        <option value="0">==市==</option>
                    </select>
                    <select name="fang_region" id="fang_region" style="width: 100px;">
                        <option value="0">==区/县==</option>
                    </select>
                </div>
                <div class="formControls col-xs-4 col-sm-5">
                    <input type="text" class="input-text" name="fang_addr" placeholder="小区详情地址和房源说明">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>租金：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" style="width: 200px;" name="fang_rent"> 元
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>楼层：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" style="width: 200px;" name="fang_floor">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>付款方式：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select name="fang_region" style="width: 200px;">
                        @foreach($fang_rent_type_data as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>几室：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" name="fang_shi" value="1">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>几厅：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" name="fang_ting" value="1">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>几卫：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" name="fang_wei" value="1">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>朝向：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select name="fang_direction" style="width: 200px;">
                        @foreach($fang_direction_data as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>租赁方式：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select name="fang_rent_class" style="width: 200px;">
                        @foreach($fang_rent_class_data as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>建筑面积：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" name="fang_build_area" value="60" style="width: 60px;">平米
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>使用面积：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" name="fang_using_area" value="40" style="width: 60px;">平米
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>建筑年代：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" onfocus="WdatePicker({dateFmt:'yyyy'})" name="fang_year" class="input-text Wdate" style="width:120px;">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>配套设施：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    @foreach($fang_config_data as $item)
                        <label>
                            <input type="checkbox" name="fang_config[]" value="{{ $item->id }}"/>
                            {{ $item->name }} &nbsp;&nbsp;
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>房屋图片：</label>
                <div class="formControls col-xs-2 col-sm-2">
                    <div id="picker">房屋图片</div>
                </div>
                <div class="formControls col-xs-6 col-sm-7">
                    <!-- 表单提交时，上传图片地址，以#隔开 -->
                    <input type="hidden" name="fang_pic" id="fang_pic"/>
                    <!-- 显示上传成功后的图片容器 -->
                    <div id="imglist"></div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>房东：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select name="fang_owner" style="width: 200px;">
                        @foreach($ownerData as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>是否推荐：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <label>
                            <input name="is_recommend" type="radio" value="0" checked>
                            否
                        </label>
                    </div>
                    <div class="radio-box">
                        <label>
                            <input type="radio" value="1" name="is_recommend">
                            是
                        </label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>房屋描述：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea name="fang_desn" class="form-control textarea"></textarea>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>房屋详情：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea id="fang_body" name="fang_body">房屋详情信息添加</textarea>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="添加房源">
                </div>
            </div>
        </form>
    </article>
@endsection

@section('js')
    <!-- webuploader上传js -->
    <script type="text/javascript" src="/webuploader/webuploader.js"></script>

    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
    <!-- 配置文件 -->
    <script type="text/javascript" src="/ueditor/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/ueditor/ueditor.all.js"></script>

    <script>
      // 下拉选择市和地区
      // obj 当前对象
      // selectName 给选中下个处理html的ID 字符串
      function selectCity(obj, selectName) {
        // 得到选中的值
        let value = $(obj).val();
        // 以省份ID得到市 发起ajax请求
        $.get('{{ route('admin.fang.city') }}', {id: value}).then(jsonArr => {
          let html = '<option value="0">==市==</option>';
          // 循环 map  for  for in    for of    $.each
          jsonArr.map(item => {
            var {id, name} = item;
            html += `<option value="${id}">${name}</option>`;
          });
          $('#' + selectName).html(html);
        });

      }
      // 富文本编辑器
      var ue = UE.getEditor('fang_body', {
        initialFrameHeight: 200
      });
      // 初始化Web Uploader
      var uploader = WebUploader.create({
        // 选完文件后，是否自动上传
        auto: true,
        // swf文件路径
        swf: '/webuploader/Uploader.swf',
        // 文件接收服务端 上传PHP的代码
        server: '{{ route('admin.fangowner.upfile') }}',
        // 文件上传是携带参数
        formData: {
          _token: '{{csrf_token()}}'
        },
        // 文件上传是的表单名称
        fileVal: 'file',
        // 选择文件的按钮
        pick: {
          id: '#picker',
          // 是否开启选择多个文件的能力
          multiple: true
        },
        // 压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        resize: true
      });
      // 上传成功时的回调方法
      uploader.on('uploadSuccess', function (file, ret) {
        // 解决表单提交时，图片以#隔开解决
        let val = $('#fang_pic').val();
        let tmp = val + '#' + ret.url;
        $('#fang_pic').val(tmp);

        // 图片显示
        let imglist = $('#imglist');
        // 注：一定要用追加还是不html覆盖
        let html = `
            <div style="position: relative;;width:100px;">
                <img src="${ret.url}" style="width:100px;" />
                <strong onclick="delpic(this,'${ret.url}')" style="position: absolute;right: 2px;top: 2px;color: white;font-size: 20px;">X<strong>
            </div>
        `;
        imglist.append(html);
      });

      // 删除图片
      function delpic(obj, picurl) {
        let url = "{{ route('admin.fangowner.delfile') }}?file=" + picurl;
        // 发起请求删除
        fetch(url);
        // 删除当前点击图片显示
        $(obj).parent().remove();
        // 修改隐藏域表单
        $('#pic').val($('#pic').val().replace(`#${picurl}`, ''));
      }

      // 前端表单验证
      $("#fang-add").validate({
        // 规则
        rules: {
          fang_name: {
            required: true
          },
          fang_province: {
            min: 1
          },
          fang_city: {
            min: 1
          },
          fang_region: {
            min: 1
          },
          fang_addr: {
            required: true
          },
          fang_rent: {
            number: true
          },
          fang_floor: {
            number: true
          },
          fang_year: {
            required: true
          },
          fang_desn:{
            required: true
          }
        },
        messages: {
          fang_province: {
            min: '省份不能为空'
          },
          fang_city: {
            min: '市不能为空'
          },
          fang_region: {
            min: '区或县不能为空'
          }
        },
        // 取消键盘事件
        onkeyup: false,
        // 验证成功后的样式
        success: "valid",
        // 验证通过后，处理的方法 form dom对象
        submitHandler: function (form) {
          // 表单提交
          form.submit();
        }
      });
    </script>

@endsection

