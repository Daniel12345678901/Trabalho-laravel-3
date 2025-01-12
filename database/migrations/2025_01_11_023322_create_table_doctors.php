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
        Schema::create('table_doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('table_users')->onDelete('cascade');
            $table->string('phone_number');
            $table->text('specialization_summary');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_doctors');
    }
};