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
        Schema::create('request_cases', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('userName');
            $table->string('email');
            $table->bigInteger('mobile_number');
            $table->integer('importance');
            $table->integer('goal_quantity');
            $table->integer('fulfilled_quantity')->default(0);

            $table->foreignId('status_id')->nullable()->constrained('request_case_statuses')->onDelete('cascade');

            $table->foreignId('case_c_id')->constrained('case_cs')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_cases');
    }
};
