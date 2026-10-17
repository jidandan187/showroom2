<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::table('transaksi', function(Blueprint $table){ if(!Schema::hasColumn('transaksi','sisa_pembayaran')) $table->decimal('sisa_pembayaran',15,2)->nullable()->after('total_harga'); });
  Schema::table('detail_transaksi', function(Blueprint $table){ if(!Schema::hasColumn('detail_transaksi','subtotal')) $table->decimal('subtotal',15,2)->default(0)->after('harga'); });
 }
 public function down(): void { Schema::table('detail_transaksi',fn(Blueprint $t)=>$t->dropColumn('subtotal')); Schema::table('transaksi',fn(Blueprint $t)=>$t->dropColumn('sisa_pembayaran')); }
};
