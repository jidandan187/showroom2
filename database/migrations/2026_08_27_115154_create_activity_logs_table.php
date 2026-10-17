<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('visitor_session_id')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();

            $table->unsignedBigInteger('mobil_id')->nullable();

            $table->string('event');

            $table->string('page')->nullable();

            $table->string('search_keyword')->nullable();

            $table->string('metadata')->nullable();

            $table->timestamps();

            $table->foreign('visitor_session_id')
                ->references('id')
                ->on('visitor_sessions')
                ->nullOnDelete();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->foreign('mobil_id')
                ->references('id')
                ->on('mobil')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};