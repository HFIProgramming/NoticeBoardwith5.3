<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::create('files', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('user_id');
		    $table->string('filename');
		    $table->string('real_name');
		    $table->string('type');
		    $table->integer('public')->default(1);
		    $table->integer('valid')->default(0);
			$table->text('intro')->nullable();
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
	    Schema::dropIfExists('files');
    }
}
