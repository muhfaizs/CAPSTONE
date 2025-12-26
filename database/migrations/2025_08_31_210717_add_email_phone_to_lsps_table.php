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
        Schema::table('lsps', function (Blueprint $table) {
            $table->string('email')->nullable()->after('license_number');
            $table->string('phone')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lsps', function (Blueprint $table) {
            $table->dropColumn(['email', 'phone']);
        });
    }
};
