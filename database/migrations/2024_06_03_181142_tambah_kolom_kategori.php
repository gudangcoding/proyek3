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
        Schema::table('kategoris', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->after('id')->nullable();
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');

            $table->unsignedBigInteger('user_id')->after('team_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kategoris', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['team_id', 'user_id']);
        });
    }
};
