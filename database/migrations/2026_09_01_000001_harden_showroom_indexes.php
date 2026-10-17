<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->unique('invoice', 'transaksi_invoice_unique');
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->index(['event', 'created_at'], 'activity_logs_event_created_at_index');
            $table->index(['mobil_id', 'event'], 'activity_logs_mobil_event_index');
        });

        Schema::table('visitor_sessions', function (Blueprint $table) {
            $table->index('last_seen_at', 'visitor_sessions_last_seen_at_index');
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropUnique('transaksi_invoice_unique');
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex('activity_logs_event_created_at_index');
            $table->dropIndex('activity_logs_mobil_event_index');
        });

        Schema::table('visitor_sessions', function (Blueprint $table) {
            $table->dropIndex('visitor_sessions_last_seen_at_index');
        });
    }
};
