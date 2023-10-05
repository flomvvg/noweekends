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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable()->default(null);
            $table->string('type');
            $table->string('weather_condition');
            $table->date('start_date');
            $table->time('start_time');
            $table->date('end_date');
            $table->time('end_time');
            $table->integer('genre_id');
            $table->integer('minimum_age');
            $table->boolean('presale_available')->default(false);
            $table->string('presale_link')->nullable()->default(null);;
            $table->boolean('box_office_available');
            $table->float('box_office_price')->nullable()->default(null);;
            $table->string('facebook_event')->nullable()->default(null);;
            $table->string('organizer_profile_type');
            $table->integer('organizer_profile_id');
            $table->boolean('venue_registered')->default(false);
            $table->integer('venue_id')->nullable()->default(null);;
            $table->string('venue_name')->nullable()->default(null);;
            $table->string('street')->nullable()->default(null);;
            $table->string('number')->nullable()->default(null);;
            $table->integer('zip')->nullable()->default(null);;
            $table->string('city')->nullable()->default(null);;
            $table->boolean('oneway')->default(false);
            $table->boolean('cancelled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
