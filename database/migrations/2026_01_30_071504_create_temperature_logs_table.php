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
    Schema::create('temperature_logs', function (Blueprint $table) {
        $table->id();
        $table->float('temperature');    // Menyimpan nilai suhu (°C)
        $table->float('humidity');       // Menyimpan nilai kelembaban (%)
        $table->string('status');        // 'Normal', 'Warning', atau 'Danger'
        $table->string('helmet_id')->nullable();
        $table->timestamps();            // Mencatat waktu real-time
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temperature_logs');
    }
};
