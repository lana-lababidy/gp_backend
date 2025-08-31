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
        Schema::create('fqas', function (Blueprint $table) {
 $table->id();
            $table->string('question');
            // was: $table->text('answer')->unique();
            $table->string('answer', 191)->unique();   // make it indexable in MySQL
            $table->integer('order');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fqas');
    }
};
