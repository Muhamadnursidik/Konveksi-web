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
        Schema::create('penggunaan_bahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_produksi_id')->constrained('job_produksi');
            $table->foreignId('bahan_baku_id')->constrained('bahan_baku');
            $table->foreignId('user_id')->constrained('users'); // pemotong
            $table->decimal('jumlah_pakai', 10, 2);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggunaan_bahan');
    }
};
