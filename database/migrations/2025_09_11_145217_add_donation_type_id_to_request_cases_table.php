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
        Schema::table('request_cases', function (Blueprint $table) {
            $table->unsignedBigInteger('donation_type_id')->after('case_c_id');
            $table->foreign('donation_type_id')->references('id')->on('donation_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_cases', function (Blueprint $table) {
            $table->dropForeign(['donation_type_id']);
            $table->dropColumn('donation_type_id');
        });
    }
};
