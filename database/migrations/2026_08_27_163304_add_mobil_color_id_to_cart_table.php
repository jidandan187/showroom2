<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cart', function (Blueprint $table) {

            $table->foreignId('mobil_color_id')
                ->nullable()
                ->after('mobil_id')
                ->constrained('mobil_colors')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('cart', function (Blueprint $table) {

            $table->dropConstrainedForeignId(
                'mobil_color_id'
            );

        });
    }
};