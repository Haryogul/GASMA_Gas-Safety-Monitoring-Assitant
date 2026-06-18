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
        Schema::create('gas_logs', function (Blueprint $table) {
            $table->id();
            // Tambahkan kolom di bawah ini:
            $table->float('ppm_level');      // Untuk menyimpan angka PPM dari sensor
            $table->string('status');         // Untuk status 'Aman' atau 'Bahaya'
            $table->string('helmet_id')->nullable(); // Opsional: Untuk menandai helm mana yang mengirim data
            $table->timestamps();             // Menghasilkan kolom created_at (Waktu masuk data)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gas_logs');
    }
};