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
        Schema::create('request_galleries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('media_type');
            $table->string('file_path');
            $table->string('title')->nullable();
            $table->string('caption')->nullable();
            $table->unsignedBigInteger('request_case_id')->nullable();
            $table->foreign('request_case_id')->references('id')->on('request_cases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_galleries');
    }
};
