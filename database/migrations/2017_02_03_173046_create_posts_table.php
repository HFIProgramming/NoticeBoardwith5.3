<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            // 帖子基本信息
            $table->string('user_id');
            $table->string('title');
            $table->longText('content');
            // $table->string('tags');  no need, https://github.com/rtconner/laravel-tagging does the same job
            // 权限设定
            $table->string('is_public')->default(1);
            $table->string('is_hidden')->nullable(); //which groups of people cannot see 对应role的定义，使用"|"分割
            $table->string('level_limitation')->nullable(); // 年级限制，使用"|"分割
            // 管理员处置
            $table->string('is_prohibited')->default(0);
            $table->string('reason')->nullable();
            // 额外信息
            $table->string('background')->nullable();
            $table->string('club_id')->nullable();  // 对应数字代表了社团的编号

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
        Schema::dropIfExists('posts');
    }
}
