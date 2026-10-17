<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { Schema::table('mobil', function(Blueprint $table){
  if(!Schema::hasColumn('mobil','status')) $table->string('status')->default('ready')->after('gambar');
  if(!Schema::hasColumn('mobil','transmisi')) $table->string('transmisi')->nullable()->after('status');
  if(!Schema::hasColumn('mobil','bahan_bakar')) $table->string('bahan_bakar')->nullable()->after('transmisi');
  if(!Schema::hasColumn('mobil','warna')) $table->string('warna')->nullable()->after('bahan_bakar');
 }); }
 public function down(): void { Schema::table('mobil', function(Blueprint $table){ foreach(['warna','bahan_bakar','transmisi','status'] as $c){ if(Schema::hasColumn('mobil',$c)) $table->dropColumn($c); } }); }
};
