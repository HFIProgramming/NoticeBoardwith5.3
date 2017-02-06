<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoteQuestionsTable extends Migration
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
            $table->string('type'); // "string" for anything or "number" for option
            $table->string('content');
            $table->string('explanation')->nullable();
            $table->string('optional')->default(0);
            $table->string('range')->default(0); // choose how many options.
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
