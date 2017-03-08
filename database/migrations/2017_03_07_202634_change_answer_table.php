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
    	Schema::table('vote_answers', function(Blueprint $table){
    		$table->renameColumn('user_id', 'source_id');
    		$table->integer('option_id')->change();
		    $table->string('source_type');
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
		    $table->dropColumn('source_type');
		    $table->renameColumn('source_id','user_id');
		    $table->string('option_id')->nullable()->change();
	    });
    }
}
