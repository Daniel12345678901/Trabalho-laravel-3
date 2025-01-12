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
        Schema::create('table_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('table_doctors')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('table_patients')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('table_rooms')->onDelete('cascade');
            $table->foreignId('schedule_id')->constrained('table_schedules')->onDelete('cascade');
            $table->dateTime('date_time');
            $table->enum('status', ['scheduled', 'completed', 'cancelled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_appointments');
    }
};