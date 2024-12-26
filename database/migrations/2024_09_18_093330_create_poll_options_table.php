<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollOptionsTable extends Migration
{
    public function up()
    {
        Schema::create('poll_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('poll_questions')->onDelete('cascade'); // Relates to poll question
            $table->string('option'); // The poll option text
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('poll_options');
    }
}
