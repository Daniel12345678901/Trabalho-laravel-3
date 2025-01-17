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
        Schema::create('table_doctor_specialty', function (Blueprint $table) {
            $table->foreignId('doctor_id')->constrained('table_doctors')->onDelete('cascade');
            $table->foreignId('specialty_id')->constrained('table_specialties')->onDelete('cascade');
            $table->primary(['doctor_id', 'specialty_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_doctor_specialty');
    }
};
