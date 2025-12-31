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
        // Get all villa IDs
        $villas = DB::table('villas')->pluck('id');
        
        foreach ($villas as $villaId) {
            // Get all feature IDs for this villa, ordered by ID
            $featureIds = DB::table('villa_features')
                ->where('villa_id', $villaId)
                ->orderBy('id')
                ->pluck('id');
            
            // If there are more than 10 features, delete the excess
            if ($featureIds->count() > 10) {
                $featureIdsToDelete = $featureIds->slice(10);
                
                DB::table('villa_features')
                    ->whereIn('id', $featureIdsToDelete)
                    ->delete();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cannot restore deleted features
    }
}; 