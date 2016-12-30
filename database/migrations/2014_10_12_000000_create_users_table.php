<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            // 登录基本信息
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('name')->unique();
            $table->string('phone_number')->unique()->nullable();  //可选
            $table->string('password');
            // 用户基本信息
            $table->string('chinese_name')->nullable();
            $table->string('english_name')->nullable();
            $table->string('wechat')->unique()->nullable();
            $table->string('avatar')->unique()->nullable();
            $table->string('class')->nullable();
            $table->string('organization')->nullable(); // 社团归属；json打包
            // 激活状态
            $table->string('is_active')->default('0');
            // 用户角色
            $table->string('role')->default('user');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
