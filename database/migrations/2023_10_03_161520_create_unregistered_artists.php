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
        Schema::create('unregistered_artists', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id');
            $table->string('name');
            $table->string('spotify')->nullable();
            $table->string('soundcloud')->nullable();
            $table->string('youtube')->nullable();
            $table->string('amazon_music')->nullable();
            $table->string('apple_music')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unregistered_artists');
    }
};
