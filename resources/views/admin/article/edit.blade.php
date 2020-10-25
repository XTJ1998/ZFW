@extends('admin.common.main')

@section('css')
    {{-- webuploader上传样式 --}}
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css"/>
@endsection
@section('cnt')
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span> 文章管理
        <span class="c-gray en">&gt;</span> 修改文章
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <article class="page-container">
        {{-- 表单验证提示 --}}
        @include('admin.common.validate')

        <form action="{{ route('admin.article.update',$article) }}" ref="frm" class="form form-horizontal">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>文章标题：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="title" v-model="info.title">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>文章描述：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" name="desn" v-model="info.desn">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>文章封面：</label>
                <div class="formControls col-xs-4 col-sm-5">
                    <!-- 表单提交时的封面地址 -->
                    <input type="hidden" name="pic" id="pic" v-model="info.pic">
                    <div id="picker">上传文章封面</div>
                </div>
                <div class="formControls col-xs-4 col-sm-4">
                    <img :src="info.pic" id="img" style="width: 100px;">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">* </span>文章内容：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea name="body" id="body" cols="30" rows="10"></textarea>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="button" @click="dopost" value="修改文章">
                </div>
            </div>
        </form>
    </article>
@endsection
@section('js')
    <!-- 引入vue -->
    <script src="/js/vue.js"></script>

    <!-- webuploader上传js -->
    <script type="text/javascript" src="/webuploader/webuploader.js"></script>
    <!-- 配置文件 -->
    <script type="text/javascript" src="/ueditor/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/ueditor/ueditor.all.js"></script>

    <script src="/js/axios.js"></script>

    <!-- 实例化编辑器 -->
    <script>
      //vue管理
      new Vue({
        el: '.page-container',
        data: {
          info:{!! $article !!}
        },
        // 组件挂载完毕
        mounted() {
          // 富文本编辑器
          this.editor = UE.getEditor('body', {
            initialFrameHeight: 200
          });
          // 渲染完毕
          this.editor.addListener("ready", () => {
            // 设置富文本内容
            //this.editor.setContent(this.info.body)
          });
          // 上传
          // 初始化Web Uploader
          this.uploader = WebUploader.create({
            // 选完文件后，是否自动上传
            auto: true,
            // swf文件路径
            swf: '/webuploader/Uploader.swf',
            // 文件接收服务端 上传PHP的代码
            server: '{{ route('admin.article.upfile') }}',
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
          this.uploader.on('uploadSuccess', (file, ret) => {
            // 图片路径
            let src = ret.url;
            this.info.pic = src;
          });
        },
        methods: {
          dopost() {
            var formData = new FormData(this.$refs.frm);
            formData.append('_token', '{{ csrf_token() }}')

            /*fetch(this.$refs.frm.action, {
              method: 'PUT',
              body: frmData
            })*/
            axios.put(this.$refs.frm.action, formData)
            /*// 获取内容
            this.info.body = this.editor.getContent();

            var frmData = new FormData(this.$refs.frm);

            // JSON字符串的转换
            //var frmData = JSON.stringify(this.info);
            let ret = await fetch(this.$refs.frm.action, {
              method: 'PUT',
              credentials: 'include',
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/x-www-form-urlencoded'
                //'Content-Type': 'application/json'
              },
              body: frmData
            });
            let json = await ret.json();
            //location.href = json.url;*/
          }
        }
      });
    </script>
@endsection

