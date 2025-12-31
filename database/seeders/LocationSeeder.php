<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run()
    {
        $locations = [
            [
                'name' => 'Kalkan',
                'slug' => 'kalkan',
                'description' => 'Antalya\'nın en güzel tatil beldelerinden biri olan Kalkan, muhteşem koyları ve tarihi dokusuyla öne çıkıyor.',
                'is_active' => true,
                'is_popular' => true
            ],
            [
                'name' => 'Kaş',
                'slug' => 'kas',
                'description' => 'Akdeniz\'in incisi Kaş, berrak denizi ve antik kentleriyle misafirlerini büyülüyor.',
                'is_active' => true,
                'is_popular' => true
            ],
            [
                'name' => 'Fethiye',
                'slug' => 'fethiye',
                'description' => 'Ölüdeniz\'in muhteşem manzarası ve doğal güzellikleriyle ünlü Fethiye, unutulmaz bir tatil vadediyor.',
                'is_active' => true,
                'is_popular' => true
            ],
            [
                'name' => 'Bodrum',
                'slug' => 'bodrum',
                'description' => 'Türkiye\'nin en popüler tatil destinasyonlarından Bodrum, eğlence ve lüksü bir arada sunuyor.',
                'is_active' => true,
                'is_popular' => false
            ],
            [
                'name' => 'Çeşme',
                'slug' => 'cesme',
                'description' => 'İzmir\'in gözde tatil beldesi Çeşme, termal kaynakları ve rüzgar sörfüyle meşhur.',
                'is_active' => true,
                'is_popular' => false
            ]
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
} 