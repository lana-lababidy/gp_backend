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
        Schema::create('otps', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('otp', 4);
            // $table->string('email')->nullable();
            $table->boolean('is_used')->default(false);
            $table->timestamp('expires_at')->nullable(); // لإضافة صلاحية للـ OTP
            $table->string('mobile_number');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
