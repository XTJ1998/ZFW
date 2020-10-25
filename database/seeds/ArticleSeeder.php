<?php

use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 清空
        \App\Models\Article::truncate();
        // 添加
        factory(\App\Models\Article::class,30)->create();
    }
}
