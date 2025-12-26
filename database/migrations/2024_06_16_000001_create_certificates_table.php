<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('certificate_registration_number');
            $table->string('participant_registration_number')->nullable();
            $table->string('competency_area')->nullable();
            $table->date('issue_date')->nullable();
            $table->string('validity_period')->nullable();
            $table->string('qualification')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('body_name')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
}; 