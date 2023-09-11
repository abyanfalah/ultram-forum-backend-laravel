<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('sub_forum_members', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('sub_forum_id');
			$table->boolean('is_admin')->default(false);
			$table->boolean('is_mod')->default(false);

			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('sub_forum_id')->references('id')->on('sub_forums');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('sub_forum_members');
	}
};
