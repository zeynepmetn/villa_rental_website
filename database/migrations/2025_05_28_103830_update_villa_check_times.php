<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tüm villaların giriş saatini 15:00, çıkış saatini 11:00 olarak güncelle
        DB::table('villas')->update([
            'check_in_time' => '15:00:00',
            'check_out_time' => '11:00:00'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Geri alma işlemi - önceki değerleri geri yükleyemeyiz
        // Bu nedenle boş bırakıyoruz
    }
};
