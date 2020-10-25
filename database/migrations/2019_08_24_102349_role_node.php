<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoleNode extends Migration
{
    /**
     * 角色与节点中间表
     */
    public function up()
    {
        Schema::create('role_node', function (Blueprint $table) {
            // 角色ID
            $table->unsignedInteger('role_id')->default(0)->comment('角色ID');
            // 节点ID
            $table->unsignedInteger('node_id')->default(0)->comment('节点ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_node');
    }
}
