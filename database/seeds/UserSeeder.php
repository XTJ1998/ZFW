<?php

use Illuminate\Database\Seeder;
// 用户模型
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 清空一数据表
        User::truncate();

        // 添加模拟数据 100用户
        factory(User::class,100)->create();

        // 规定id1=1用户名为admin
        User::where('id',1)->update(['username'=>'admin']);


    }
}
