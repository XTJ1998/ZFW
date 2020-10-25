@extends('admin.common.main')

@section('css')
    {{-- webuploader上传样式 --}}
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css"/>
@endsection

@section('cnt')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 房东管理
        <span class="c-gray en">&gt;</span> 添加房东
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <article class="page-container">
        {{-- 表单验证提示 --}}
        @include('admin.common.validate')

        <form action="{{ route('admin.fangowner.store') }}" method="post" class="form form-horizontal" id="form-member-add">
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>姓名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="name" value="{{ old('name') }}">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>年龄：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="age">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机号码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="phone">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="email">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>身份证码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="card">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>地址：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="address">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>
                <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                    <div class="radio-box">
                        <input name="sex" type="radio" value="男" checked>
                        <label for="sex-1">男</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" value="女" name="sex">
                        <label for="sex-2">女</label>
                    </div>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>身份证照片：</label>
                <div class="formControls col-xs-2 col-sm-2">
                    <div id="picker">身份证照片</div>
                    <span>正面、反面、手持</span>
                </div>
                <div class="formControls col-xs-6 col-sm-7">
                    <!-- 表单提交时，上传图片地址，以#隔开 -->
                    <input type="hidden" name="pic" id="pic"/>
                    <!-- 显示上传成功后的图片容器 -->
                    <div id="imglist"></div>
                </div>
            </div>

            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="添加房东">
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

    <script>
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
        let val = $('#pic').val();
        let tmp = val + '#' + ret.url;
        $('#pic').val(tmp);

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

      // 单选框样式
      $('.skin-minimal input').iCheck({
        checkboxClass: 'icheckbox-blue',
        radioClass: 'iradio-blue',
        increaseArea: '20%'
      });

      // 前端表单验证
      $("#form-member-add").validate({
        // 规则
        rules: {
          // 表单元素名称
          name: {
            // 验证规则
            required: true
          },
          card: {
            required: true
          },
          email: {
            required: true,
            email: true
          },
          phone: {
            required: true,
            phone: true
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

      // 自定义验证规则
      // 邮政编码验证
      jQuery.validator.addMethod("phone", function (value, element) {
        // patrn = /^(\+86-)?1[3-9]\d{9}$/;
        var reg1 = /^\+86-1[3-9]\d{9}$/;
        var reg2 = /^1[3-9]\d{9}$/;
        var ret = reg1.test(value) || reg2.test(value);
        return this.optional(element) || ret;
      }, "请输入正确的手机号码");


    </script>

@endsection

