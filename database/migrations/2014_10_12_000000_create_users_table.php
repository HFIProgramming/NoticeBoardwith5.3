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
            $table->string('chinese_name');
            $table->string('email')->default('null');
            $table->string('name')->default('visitor');
            $table->string('phone_number')->nullable();  //可选
            $table->string('password');
            // 用户基本信息
            $table->string('english_name')->nullable();
            $table->string('wechat')->nullable();
            $table->string('avatar')->nullable();
            $table->string('class')->nullable();
            $table->string('organization')->nullable(); // 社团归属；json打包
            $table->string('grade'); // xx学年，从学年判断年级
            $table->string('powerschool_id')->nullable();
            $table->text('self_intro')->nullable();
            // 激活状态
            $table->string('active')->default('0');
            $table->integer('blacklisted')->default(0); // 黑名单
            // 用户角色
            $table->string('role')->default('student'); // student,teacher,admin
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
