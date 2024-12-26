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
        Schema::table('friends', function (Blueprint $table) {
            $table->unsignedBigInteger('blocked_by')->nullable()->after('friend_type');
            $table->foreign('blocked_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('friends', function (Blueprint $table) {
            $table->dropForeign(['blocked_by']);
            $table->dropColumn('blocked_by');
        });
    }
};
