<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('poll_questions', function (Blueprint $table) {
            $table->integer('max_votes')->default(0); // default value of 0 means no vote limit
        });
    }
    
    public function down()
    {
        Schema::table('poll_questions', function (Blueprint $table) {
            $table->dropColumn('max_votes');
        });
    }
    
};
