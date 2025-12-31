<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Villa;
use App\Models\Location;
use App\Models\User;
use App\Models\VillaImage;
use App\Models\Feature;
use Illuminate\Support\Str;
use Faker\Factory as FakerFactory;

class VillaSeeder extends Seeder
{
    public function run()
    {
        // Foreign key hatası almamak için foreign key check'i kapat
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('bookings')->truncate();
        \DB::table('villa_features')->truncate();
        \DB::table('villa_images')->truncate();
        Villa::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get all locations and realtors
        $locations = Location::all();
        $realtors = User::role('realtor')->get();

        if ($locations->isEmpty()) {
            $this->command->error('Önce lokasyon ekleyin!');
            return;
        }

        if ($realtors->isEmpty()) {
            $this->command->error('Önce emlakçı ekleyin!');
            return;
        }

        $faker = FakerFactory::create();

        // 20 villa ismi
        $villaNames = [
            'Lüks Deniz Manzaralı Villa',
            'Modern Havuzlu Villa',
            'Özel Plajlı Villa',
            'Muhteşem Manzaralı Villa',
            'Jakuzili Lüks Villa',
            'Doğa İçinde Villa',
            'Infinity Havuzlu Villa',
            'Sahil Kenarı Villa',
            'Panoramik Manzaralı Villa',
            'Ultra Lüks Villa',
            'Özel Tasarım Villa',
            'Bahçeli Müstakil Villa',
            'Spa & Havuzlu Villa',
            'Denize Sıfır Villa',
            'Orman Manzaralı Villa',
            'Teraslı Lüks Villa',
            'Özel Havuzlu Villa',
            'Muhteşem Konumlu Villa',
            'Ayrıcalıklı Villa',
            'Premium Villa'
        ];

        $features = [
            'Özel Havuz',
            'Jakuzi',
            'Sauna',
            'Fitness Salonu',
            'Oyun Odası',
            'Sinema Odası',
            'Barbekü Alanı',
            'Güvenlik Sistemi',
            'Otopark',
            'Bahçe',
            'Teras',
            'Şömine',
            'Klima',
            'Wi-Fi',
            'Çamaşır Makinesi',
            'Bulaşık Makinesi',
            'Mutfak Eşyaları',
            'TV',
            'Ses Sistemi'
        ];

        // Özelliklerin id'lerini al (veritabanındaki ilk 10 özellik)
        $featureIds = Feature::orderBy('id')->limit(10)->pluck('id')->toArray();

        // 20 villa oluştur
        for ($i = 1; $i <= 20; $i++) {
            $name = $villaNames[$i-1];
            $villa = Villa::create([
                'title' => $name,
                'slug' => Str::slug($name) . '-' . $i,
                'description' => $faker->paragraphs(2, true),
                'location_id' => $locations->random()->id,
                'realtor_id' => $realtors->random()->id,
                'bedrooms' => $faker->numberBetween(2, 6),
                'bathrooms' => $faker->numberBetween(1, 4),
                'capacity' => $faker->numberBetween(4, 12),
                'size' => $faker->numberBetween(120, 400),
                'price_per_night' => $faker->numberBetween(1500, 8000),
                'cleaning_fee' => $faker->numberBetween(200, 800),
                'is_active' => true,
                'is_featured' => $faker->boolean(30),
                'check_in_time' => '15:00',
                'check_out_time' => '11:00',
                'min_stay' => $faker->numberBetween(2, 7),
                'address' => $faker->address,
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude,
            ]);

            // Rastgele 3-6 özellik ata (sadece id'ler)
            shuffle($featureIds);
            $randomFeatureIds = array_slice($featureIds, 0, rand(3, 6));
            $villa->features()->attach($randomFeatureIds);

            // Placeholder görsel ekle (isteğe bağlı)
            $villa->images()->create([
                'path' => 'images/villa-placeholder.jpg',
                'is_primary' => true,
                'order' => 1
            ]);
        }
    }
} 