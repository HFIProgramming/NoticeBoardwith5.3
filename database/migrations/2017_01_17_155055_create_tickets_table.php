<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vote_id'); // Belong to specific vote
            $table->string('active')->default('0'); // only when 1 can be used
            $table->string('is_used')->default('0'); // used 1
            $table->string('string');
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
        Schema::dropIfExists('tickets');
    }
}
