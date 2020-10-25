<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * 文章表
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',200)->comment('文章标题');
            $table->string('desn',255)->default('')->comment('文章摘要');
            $table->string('pic',100)->default('')->comment('文章封面');
            $table->string('url',255)->default('')->comment('内容页链接');
            $table->text('body')->comment('文章内容');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
