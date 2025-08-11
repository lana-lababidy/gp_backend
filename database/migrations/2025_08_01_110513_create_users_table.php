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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            
            // الهوية
            $table->string('username')->unique();
            $table->string('aliasname')->nullable();
            $table->string('mobile_number')->unique();

            // الحماية
            $table->string('password');
            $table->string('user_session')->nullable();
            $table->string('fcm_token')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // العلاقات

            // $table->unsignedBigInteger('wallet_id')->nullable();
            // $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('set null');
            // $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
        // Schema::dropIfExists('password_reset_tokens');
        Schema::enableForeignKeyConstraints();
    }
};
