<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('clubs', function (Blueprint $table) {
            $table->increments('id');
            // 社团基本信息
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->text('self_intro');
            // 权限设定
            $table->string('role_limitation');  // 只对指定人员开放,多个年级用"|"分离
            $table->string('is_public')->default(1); // 是否对外开放，1 无限制，0 需要登录
            $table->string('level_limitation')->nullable(); // 只对指定年级，多个年级用"|"分离
            // 额外信息
            $table->string('background')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('clubs');
    }
}
