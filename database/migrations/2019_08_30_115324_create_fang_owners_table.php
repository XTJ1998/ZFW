<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFangOwnersTable extends Migration
{
    /**
     * 房东表
     */
    public function up()
    {
        Schema::create('fang_owners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',50)->comment('房东姓名');
            $table->enum('sex',['男','女'])->default('男')->comment('性别');
            $table->unsignedTinyInteger('age')->default(20)->comment('年龄');
            $table->char('phone',15)->comment('手机号码');
            $table->string('card',20)->comment('身份号码');
            $table->string('address',100)->comment('家庭住址');
            $table->string('pic',200)->comment('身份证照片');
            $table->string('email',50)->default('')->comment('邮箱');
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
        Schema::dropIfExists('fang_owners');
    }
}
