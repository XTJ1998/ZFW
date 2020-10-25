<?php


Route::get('/', function () {
    return bcrypt('admin888');
});

// 引入定义好的后台路由文件
include base_path('routes/admin/admin.php');


