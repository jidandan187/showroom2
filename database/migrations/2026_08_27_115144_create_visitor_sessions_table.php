<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitor_sessions', function (Blueprint $table) {

            $table->id();

            $table->string('session_id')->unique();

            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('ip_address', 45)->nullable();

            $table->string('user_agent')->nullable();

            $table->string('landing_page')->nullable();

            $table->timestamp('first_seen_at')->nullable();

            $table->timestamp('last_seen_at')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_sessions');
    }
};