<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * This migration adds file_content column to store certificate files as binary data
     * This is necessary for Vercel deployment since Vercel has ephemeral filesystem
     */
    public function up(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->longText('file_content')->nullable()->after('file_path');
            $table->string('file_mime_type')->nullable()->after('file_content');
            $table->string('file_name')->nullable()->after('file_mime_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn(['file_content', 'file_mime_type', 'file_name']);
        });
    }
};
