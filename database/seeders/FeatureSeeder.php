<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feature;

class FeatureSeeder extends Seeder
{
    public function run()
    {
        $features = [
            [
                'name' => 'Özel Havuz',
                'icon' => 'swimming-pool',
                'description' => 'Villa\'ya özel yüzme havuzu'
            ],
            [
                'name' => 'Deniz Manzarası',
                'icon' => 'water',
                'description' => 'Muhteşem deniz manzarası'
            ],
            [
                'name' => 'Jakuzi',
                'icon' => 'hot-tub',
                'description' => 'Özel jakuzi'
            ],
            [
                'name' => 'Bahçe',
                'icon' => 'tree',
                'description' => 'Özel bahçe alanı'
            ],
            [
                'name' => 'Barbekü',
                'icon' => 'fire',
                'description' => 'Barbekü alanı'
            ],
            [
                'name' => 'Wi-Fi',
                'icon' => 'wifi',
                'description' => 'Ücretsiz Wi-Fi'
            ],
            [
                'name' => 'Klima',
                'icon' => 'snowflake',
                'description' => 'Merkezi klima sistemi'
            ],
            [
                'name' => 'Otopark',
                'icon' => 'parking',
                'description' => 'Özel otopark alanı'
            ],
            [
                'name' => 'Güvenlik',
                'icon' => 'shield-alt',
                'description' => '7/24 güvenlik'
            ],
            [
                'name' => 'Oyun Odası',
                'icon' => 'gamepad',
                'description' => 'Oyun ve eğlence odası'
            ]
        ];

        foreach ($features as $feature) {
            Feature::create($feature);
        }
    }
} 