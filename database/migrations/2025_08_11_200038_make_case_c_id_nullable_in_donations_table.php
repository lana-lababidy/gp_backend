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
        Schema::table('donations', function (Blueprint $table) {
            // $table->unsignedBigInteger('case_c_id')->nullable();
            // $table->foreign('case_c_id')->references('id')->on('case_cs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            // $table->unsignedBigInteger('case_c_id')->nullable(false)->change();
        });
    }
};
