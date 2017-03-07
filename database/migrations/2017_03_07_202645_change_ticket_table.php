<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::table('tickets', function (Blueprint $table) {
		    $table->dropColumn('is_used');
		    $table->dropColumn('vote_id');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('tickets', function (Blueprint $table) {
		    $table->integer('is_used');
		    $table->integer('vote_id');
	    });

    }
}
