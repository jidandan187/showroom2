<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::create('mobil_images', function(Blueprint $table){ $table->id(); $table->foreignId('mobil_id')->constrained('mobil')->cascadeOnDelete(); $table->string('gambar'); $table->timestamps(); }); }
 public function down(): void { Schema::dropIfExists('mobil_images'); }
};
