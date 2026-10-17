<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('transaksi', function (Blueprint $table) {

    $table->id();

    $table->string('invoice');

    $table->foreignId('user_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->decimal('total_harga',15,2);

    $table->enum(
        'metode_pembayaran',
        ['cash','kredit']
    );

    $table->decimal('dp',15,2)->nullable();

    $table->integer('tenor')->nullable();

    $table->decimal(
        'cicilan_per_bulan',
        15,
        2
    )->nullable();

    $table->enum(
        'status',
        ['pending','proses','selesai']
    )->default('pending');

    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};