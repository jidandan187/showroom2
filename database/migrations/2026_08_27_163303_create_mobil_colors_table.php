<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mobil_colors', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mobil_id')
                ->constrained('mobil')
                ->cascadeOnDelete();

            $table->string('nama_warna');
            $table->string('kode_warna')->nullable();
            $table->boolean('tersedia')->default(true);
            $table->unsignedInteger('stok')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobil_colors');
    }
};
