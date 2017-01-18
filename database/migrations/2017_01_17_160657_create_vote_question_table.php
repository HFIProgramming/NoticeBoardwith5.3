<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoteQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('vote_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vote_id');
            $table->string('type'); // string for anything or number for option
            $table->string('content');
            $table->string('explaination')->nullable();
            $table->string('range')->nullable(); // check option is legal
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
        Schema::dropIfExists('vote_questions');
    }
}
