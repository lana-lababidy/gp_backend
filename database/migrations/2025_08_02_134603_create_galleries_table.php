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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();

            $table->string('media_type');
            $table->string('file_path');
            $table->string('caption');
            $table->string('title');

            $table->unsignedBigInteger('donation_id');
            $table->foreign('donation_id')->references('id')->on('donations')->onDelete('cascade');

            $table->unsignedBigInteger('case_c_id');
            $table->foreign('case_c_id')->references('id')->on('case_cs')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
