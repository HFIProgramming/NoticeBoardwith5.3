<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('club_users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('club_id');
			$table->string('user_id');
			$table->string('role')->default('applicant');  //  applicant; member; charger; master
			$table->string('status')->default('pending'); // pending;approved;rejected;blacklisted
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
		Schema::dropIfExists('club_users');
	}
}
