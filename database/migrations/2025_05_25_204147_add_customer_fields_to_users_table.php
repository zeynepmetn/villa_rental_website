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
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('profile_image');
            $table->string('city')->nullable()->after('address');
            $table->date('birth_date')->nullable()->after('city');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('birth_date');
            $table->text('bio')->nullable()->after('gender');
            $table->boolean('notifications_email')->default(true)->after('bio');
            $table->boolean('notifications_sms')->default(false)->after('notifications_email');
            $table->string('language', 2)->default('tr')->after('notifications_sms');
            $table->string('currency', 3)->default('TRY')->after('language');
            $table->boolean('profile_public')->default(false)->after('currency');
            $table->boolean('show_booking_history')->default(false)->after('profile_public');
            $table->timestamp('last_login_at')->nullable()->after('show_booking_history');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'avatar',
                'city',
                'birth_date',
                'gender',
                'bio',
                'notifications_email',
                'notifications_sms',
                'language',
                'currency',
                'profile_public',
                'show_booking_history',
                'last_login_at'
            ]);
        });
    }
};
