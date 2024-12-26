<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('poll_questions', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Poll question or title
            $table->boolean('is_private')->default(false); // False = Public, True = Private
            $table->timestamp('start_time')->nullable(); // Optional start time
            $table->timestamp('end_time')->nullable(); // Optional end time
            $table->enum('status', ['open', 'closed'])->default('open'); // Status of the poll
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('poll_questions');
    }
}
