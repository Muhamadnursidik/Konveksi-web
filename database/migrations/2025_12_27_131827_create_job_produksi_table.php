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
        Schema::create('job_produksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_pakaian_id')->constrained('model_pakaian');
            $table->foreignId('bahan_baku_id')->constrained('bahan_baku');
            $table->integer('jumlah_target');
            $table->decimal('kebutuhan_bahan_total', 10, 2); // meter
            $table->enum('status', [
                'menunggu',
                'dipotong',
                'dijahit',
                'finishing',
                'selesai',
            ])->default('menunggu');
            $table->foreignId('pemotong_id')->nullable()->constrained('users');
            $table->foreignId('penjahit_id')->nullable()->constrained('users');
            $table->foreignId('finishing_id')->nullable()->constrained('users');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_produksi');
    }
};
