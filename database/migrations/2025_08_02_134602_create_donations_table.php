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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');

            $table->unsignedBigInteger('donation_type_id');
            $table->foreign('donation_type_id')->references('id')->on('donation_types')->onDelete('cascade');

            $table->foreignId('status_id')->constrained('donation_statuses')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('case_c_id');
            $table->foreign('case_c_id')->references('id')->on('case_cs')->onDelete('cascade');

            $table->integer('points')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
