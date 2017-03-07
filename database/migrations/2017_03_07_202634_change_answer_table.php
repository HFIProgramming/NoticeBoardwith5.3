<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table('vote_answers', function($table){
    		$table->renameColumn('user_id', 'answerable_id');
		    $table->string('answerable_type')->nullable();
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
	    Schema::table('vote_answers', function (Blueprint $table) {
		    $table->dropColumn('answerable_type');
		    $table->renameColumn('answerable_id','user_id');
	    });
    }
}
