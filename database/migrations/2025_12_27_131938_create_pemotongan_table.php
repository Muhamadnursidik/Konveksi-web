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
        Schema::create('pemotongan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_produksi_id')->constrained('job_produksi');
            $table->foreignId('pemotong_id')->constrained('users');
            $table->string('foto_bukti');
            $table->enum('status', ['pending', 'dipotong'])->default('pending');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemotongan');
    }
};
