{{--判断是否有success闪存--}}
@if(session()->has('success'))
    <div class="Huialert Huialert-success"><i class="Hui-iconfont">&#xe6a6;</i>
    {{ session('success') }}
    </div>
@endif


