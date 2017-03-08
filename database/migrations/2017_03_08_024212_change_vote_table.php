<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeVoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::table('votes', function (Blueprint $table) {
		    $table->integer('show_result')->default(1); // 1 show 0 no
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
	    Schema::table('votes', function (Blueprint $table) {
		    $table->dropColumn('show_result');
	    });
    }
}
