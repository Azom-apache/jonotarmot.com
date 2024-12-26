<?php

use App\Models\Branch;
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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->date('birthday')->nullable();
            $table->string('nid')->nullable();
            $table->string('address')->nullable();
            $table->string('photo')->nullable();
            $table->foreignId('branch_id')->nullable()->constrained('branches');
            $table->string('designation')->nullable();
            $table->string('phone')->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            $table->string('eSalaryAcc')->nullable();
            $table->integer('payLeave')->default(0);
            $table->integer('npayLeave')->default(0);
            $table->date('evmoSalarydate')->nullable();
            $table->enum('status', ['Active', 'Inactive', 'On Leave'])->default('Active');
            $table->date('joinDate')->nullable();
            $table->time('joinTime')->nullable();
            $table->string('author')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
