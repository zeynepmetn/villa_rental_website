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
        Schema::create('villas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->foreignId('location_id')->constrained()->cascadeOnDelete();
            $table->foreignId('realtor_id')->constrained('users')->cascadeOnDelete();
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('capacity');
            $table->integer('size');
            $table->decimal('price_per_night', 10, 2);
            $table->decimal('cleaning_fee', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->time('check_in_time');
            $table->time('check_out_time');
            $table->integer('min_stay')->default(1);
            $table->string('address');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('villas');
    }
};
