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
        Schema::create('sub_forum_mods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('membership_id');
            $table->boolean('is_admin');

            $table->timestamps();

            $table->foreign('membership_id')->references('id')->on('sub_forum_members');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_forum_mods');
    }
};
