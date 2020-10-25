<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodesTable extends Migration
{
    /**
     * 节点表，也叫权限表
     */
    public function up()
    {
        Schema::create('nodes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name',50)->comment('节点名称');
            $table->string('route_name',100)->nullable()->default('')->comment('路由别名，权限认证标识');
            $table->unsignedInteger('pid')->default(0)->comment('上级ID');
            $table->enum('is_menu',['0','1'])->default('0')->comment('是否为菜单0否，1是');

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
        Schema::dropIfExists('nodes');
    }
}
