<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 调用生成管理员数据表
        $this->call(UserSeeder::class);

        //$this->call(ArticleSeeder::class);
    }
}
