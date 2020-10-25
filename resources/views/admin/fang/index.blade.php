<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui/css/H-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/H-ui.admin.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/skin/default/skin.css" id="skin"/>
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="/css/pagination.css"/>
    <title>用户列表</title>
</head>
<body>
<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i> 首页
    <span class="c-gray en">&gt;</span> 房源管理
    <span class="c-gray en">&gt;</span> 房源列表
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
</nav>

{{-- 消息提示 --}}
@include('admin.common.msg')

<div class="page-container">
    <div class="text-c"> 日期范围：
        <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
        -
        <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;">
        <input type="text" class="input-text" style="width:250px" placeholder="输入会员名称、电话、邮箱" id="" name="">
        <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a class="btn btn-danger radius" onclick="deleteAll()">
                <i class="Hui-iconfont">&#xe6e2;</i> 批量删除
            </a>
            <a href="{{ route('admin.fang.create') }}" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加房源
            </a>
            <a href="#" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 导出成excel
            </a>
        </span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="30">ID</th>
                <th width="100">房源名称</th>
                <th width="100">小区名称</th>
                <th width="150">小区地址</th>
                <th width="60">租赁方式</th>
                <th width="90">业主</th>
                <th width="150">租金</th>
                <th width="40">朝向</th>
                <th width="150">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr class="text-c">
                    <td><input type="checkbox" value="{{ $item->id }}" name="id[]"></td>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->fang_name }}</td>
                    <td>{{ $item->fang_xiaoqu }}</td>
                    <td>{{ $item->fang_addr }}</td>
                    <td>{{ $item->fang_rent_class }}</td>
                    <td>{{ $item->fang_owner }}</td>
                    <td>{{ $item->fang_rent }}</td>
                    <td>{{ $item->fang_direction }}</td>
                    <td class="td-manage text-l">
                        {!! $item->editBtn('admin.fang.edit') !!}
                        {!! $item->deleteBtn('admin.fang.destroy') !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{-- 分页 支持搜索功能 --}}
        {{ $data->appends(request()->except('page'))->links() }}
    </div>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/admin/lib/laypage/1.2/laypage.js"></script>
<script>
  // 生成一个token crsf
  const _token = "{{ csrf_token() }}";

  // 给删除按钮绑定事件
  $('.delbtn').click(function (evt) {
    // 得到请求的url地址
    let url = $(this).attr('href');
    // 发起一个delete请求
    $.ajax({
      url,
      data: {_token},
      type: 'DELETE',
      dataType: 'json'
    }).then(({status, msg}) => {
      if (status == 0) {
        // 提示插件
        layer.msg(msg, {time: 2000, icon: 1}, () => {
          // 删除当前行
          $(this).parents('tr').remove();
        });
      }
    });
    // jquery取消默认事件
    return false;
  });

  // 全选删除
  function deleteAll() {
    // 询问框
    layer.confirm('您是真的要删除选中的用户吗？', {
      btn: ['确认删除', '思考一下']
    }, () => {
      // 选中的用户
      let ids = $('input[name="id[]"]:checked');
      // 删除的ID
      let id = [];
      // 循环
      $.each(ids, (key, val) => {
        // dom对象 转为 jquery对象 $(dom对象)
        // id.push($(val).val());
        id.push(val.value);
      });
      if (id.length > 0) {
        // 发起ajax
        $.ajax({
          url: "{{ route('admin.user.delall') }}",
          data: {id, _token},
          type: 'DELETE'
        }).then(ret => {
          if (ret.status == 0) {
            layer.msg(ret.msg, {time: 2000, icon: 1}, () => {
              location.reload();
            })
          }
        })

      }

    });


  }

</script>
</body>
</html>
