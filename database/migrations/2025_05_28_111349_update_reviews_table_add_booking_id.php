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
        Schema::table('reviews', function (Blueprint $table) {
            // Check if booking_id column doesn't exist
            if (!Schema::hasColumn('reviews', 'booking_id')) {
                $table->foreignId('booking_id')->nullable()->after('id')->constrained()->onDelete('cascade');
                $table->unique('booking_id');
            }
            
            // Check if is_approved column doesn't exist
            if (!Schema::hasColumn('reviews', 'is_approved')) {
                $table->boolean('is_approved')->default(false)->after('comment');
            }
            
            // Add indexes if they don't exist
            // $table->index(['villa_id', 'is_approved']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            if (Schema::hasColumn('reviews', 'booking_id')) {
                $table->dropForeign(['booking_id']);
                $table->dropUnique(['booking_id']);
                $table->dropColumn('booking_id');
            }
            
            if (Schema::hasColumn('reviews', 'is_approved')) {
                $table->dropColumn('is_approved');
            }
        });
    }
};
