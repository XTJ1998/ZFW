@extends('admin.common.main')

@section('css')
    {{-- webuploader上传样式 --}}
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css"/>
@endsection

@section('cnt')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 房源属性管理
        <span class="c-gray en">&gt;</span> 添加房源属性
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <article class="page-container">
        {{-- 表单验证提示 --}}
        @include('admin.common.validate')

        <form action="{{ route('admin.fangattr.store') }}" id="form-member-add" method="post" class="form form-horizontal">
            @csrf

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>是否顶级：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box">
                        <select class="select" name="pid">
                            <option value="0">==顶级==</option>
                            @foreach($data as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>属性名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="name"/>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>属性图标：</label>
                <div class="formControls col-xs-4 col-sm-5">
                    <!-- 图片上传 -->
                    <div id="picker">选择图标</div>
                </div>
                <div class="formControls col-xs-4 col-sm-4">
                    <input type="hidden" value="{{ config('up.pic') }}" name="icon" id="icon"/>
                    <img src="{{ config('up.pic') }}" id="pic" style="width: 50px;">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">字段名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="field_name"/>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="添加属性">
                </div>
            </div>
        </form>
    </article>
@endsection

@section('js')
    <!-- webuploader上传js -->
    <script type="text/javascript" src="/webuploader/webuploader.js"></script>
    <!-- 前端验证 --->
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
    <script>
      // 前端表单验证
      $("#form-member-add").validate({
        // 规则
        rules: {
          // 表单元素名称
          name: {
            // 验证规则
            required: true
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


      // 初始化Web Uploader
      var uploader = WebUploader.create({
        // 选完文件后，是否自动上传
        auto: true,
        // swf文件路径
        swf: '/webuploader/Uploader.swf',
        // 文件接收服务端 上传PHP的代码
        server: '{{ route('admin.fangattr.upfile') }}',
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
          multiple: false
        },
        // 压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        resize: true
      });
      // 上传成功时的回调方法
      uploader.on('uploadSuccess', function (file, ret) {
        // 图片路径
        let src = ret.url;
        // 给表单添加value值
        $('#icon').val(src);
        // 给图片添加src
        $('#pic').attr('src', src);

      });
    </script>
@endsection

