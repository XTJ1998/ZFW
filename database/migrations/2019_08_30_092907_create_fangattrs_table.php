<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFangattrsTable extends Migration
{
    /**
     * 房源属性表
     */
    public function up()
    {
        Schema::create('fangattrs', function (Blueprint $table) {
            // 主键
            $table->bigIncrements('id');
            $table->unsignedInteger('pid')->default(0)->comment('上级ID');
            $table->string('field_name',50)->default('')->comment('字段名');
            $table->string('name',50)->default('')->comment('属性名称');
            $table->string('icon',200)->default('')->comment('图标');
            $table->timestamps();
            // 软删除
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
        Schema::dropIfExists('fangattrs');
    }
}
