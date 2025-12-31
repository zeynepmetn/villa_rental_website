<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Villa;
use App\Models\User;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Müşteri rolündeki kullanıcıları al
        $customers = User::role('customer')->get();
        
        // Aktif villaları al
        $villas = Villa::where('is_active', true)->get();
        
        if ($customers->isEmpty() || $villas->isEmpty()) {
            $this->command->warn('Müşteri veya villa bulunamadı. Önce UserSeeder ve VillaSeeder çalıştırın.');
            return;
        }
        
        $bookings = [];
        
        // 1. Geçmiş rezervasyonlar (tamamlanmış)
        for ($i = 0; $i < 15; $i++) {
            $villa = $villas->random();
            $customer = $customers->random();
            
            $checkIn = Carbon::now()->subDays(rand(30, 180));
            $nights = rand(3, 14);
            $checkOut = $checkIn->copy()->addDays($nights);
            
            $bookings[] = [
                'villa_id' => $villa->id,
                'customer_id' => $customer->id,
                'check_in' => $checkIn->format('Y-m-d'),
                'check_out' => $checkOut->format('Y-m-d'),
                'guests' => rand(1, min(6, $villa->max_guests)),
                'total_price' => $nights * $villa->price_per_night,
                'status' => 'completed',
                'notes' => $this->getRandomNote(),
                'created_at' => $checkIn->subDays(rand(1, 30)),
                'updated_at' => $checkOut->addDays(1),
            ];
        }
        
        // 2. Aktif rezervasyonlar (şu anda devam eden)
        for ($i = 0; $i < 5; $i++) {
            $villa = $villas->random();
            $customer = $customers->random();
            
            $checkIn = Carbon::now()->subDays(rand(1, 5));
            $nights = rand(5, 14);
            $checkOut = $checkIn->copy()->addDays($nights);
            
            $bookings[] = [
                'villa_id' => $villa->id,
                'customer_id' => $customer->id,
                'check_in' => $checkIn->format('Y-m-d'),
                'check_out' => $checkOut->format('Y-m-d'),
                'guests' => rand(1, min(8, $villa->max_guests)),
                'total_price' => $nights * $villa->price_per_night,
                'status' => 'confirmed',
                'notes' => $this->getRandomNote(),
                'created_at' => $checkIn->subDays(rand(7, 45)),
                'updated_at' => $checkIn->subDays(rand(1, 7)),
            ];
        }
        
        // 3. Gelecek rezervasyonlar (onaylanmış)
        for ($i = 0; $i < 20; $i++) {
            $villa = $villas->random();
            $customer = $customers->random();
            
            $checkIn = Carbon::now()->addDays(rand(1, 120));
            $nights = rand(3, 21);
            $checkOut = $checkIn->copy()->addDays($nights);
            
            $bookings[] = [
                'villa_id' => $villa->id,
                'customer_id' => $customer->id,
                'check_in' => $checkIn->format('Y-m-d'),
                'check_out' => $checkOut->format('Y-m-d'),
                'guests' => rand(1, min(10, $villa->max_guests)),
                'total_price' => $nights * $villa->price_per_night,
                'status' => 'confirmed',
                'notes' => $this->getRandomNote(),
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now()->subDays(rand(0, 15)),
            ];
        }
        
        // 4. Onay bekleyen rezervasyonlar
        for ($i = 0; $i < 8; $i++) {
            $villa = $villas->random();
            $customer = $customers->random();
            
            $checkIn = Carbon::now()->addDays(rand(5, 60));
            $nights = rand(3, 10);
            $checkOut = $checkIn->copy()->addDays($nights);
            
            $bookings[] = [
                'villa_id' => $villa->id,
                'customer_id' => $customer->id,
                'check_in' => $checkIn->format('Y-m-d'),
                'check_out' => $checkOut->format('Y-m-d'),
                'guests' => rand(1, min(6, $villa->max_guests)),
                'total_price' => $nights * $villa->price_per_night,
                'status' => 'pending',
                'notes' => $this->getRandomNote(),
                'created_at' => Carbon::now()->subDays(rand(0, 7)),
                'updated_at' => Carbon::now()->subDays(rand(0, 3)),
            ];
        }
        
        // 5. İptal edilmiş rezervasyonlar
        for ($i = 0; $i < 6; $i++) {
            $villa = $villas->random();
            $customer = $customers->random();
            
            $checkIn = Carbon::now()->addDays(rand(10, 90));
            $nights = rand(3, 14);
            $checkOut = $checkIn->copy()->addDays($nights);
            
            $bookings[] = [
                'villa_id' => $villa->id,
                'customer_id' => $customer->id,
                'check_in' => $checkIn->format('Y-m-d'),
                'check_out' => $checkOut->format('Y-m-d'),
                'guests' => rand(1, min(8, $villa->max_guests)),
                'total_price' => $nights * $villa->price_per_night,
                'status' => 'cancelled',
                'notes' => $this->getRandomNote(),
                'created_at' => Carbon::now()->subDays(rand(5, 30)),
                'updated_at' => Carbon::now()->subDays(rand(1, 15)),
            ];
        }
        
        // 6. Özel durumlar - Uzun süreli rezervasyonlar
        for ($i = 0; $i < 3; $i++) {
            $villa = $villas->random();
            $customer = $customers->random();
            
            $checkIn = Carbon::now()->addDays(rand(30, 90));
            $nights = rand(21, 45); // Uzun süreli
            $checkOut = $checkIn->copy()->addDays($nights);
            
            $bookings[] = [
                'villa_id' => $villa->id,
                'customer_id' => $customer->id,
                'check_in' => $checkIn->format('Y-m-d'),
                'check_out' => $checkOut->format('Y-m-d'),
                'guests' => rand(4, min(12, $villa->max_guests)),
                'total_price' => $nights * $villa->price_per_night * 0.9, // %10 indirim
                'status' => 'confirmed',
                'notes' => 'Uzun süreli konaklama - %10 indirim uygulandı. ' . $this->getRandomNote(),
                'created_at' => Carbon::now()->subDays(rand(10, 45)),
                'updated_at' => Carbon::now()->subDays(rand(5, 20)),
            ];
        }
        
        // Veritabanına toplu ekleme
        foreach (array_chunk($bookings, 50) as $chunk) {
            Booking::insert($chunk);
        }
        
        $this->command->info('Toplam ' . count($bookings) . ' rezervasyon oluşturuldu:');
        $this->command->info('- 15 tamamlanmış rezervasyon');
        $this->command->info('- 5 aktif rezervasyon');
        $this->command->info('- 20 gelecek rezervasyon');
        $this->command->info('- 8 onay bekleyen rezervasyon');
        $this->command->info('- 6 iptal edilmiş rezervasyon');
        $this->command->info('- 3 uzun süreli rezervasyon');
    }
    
    /**
     * Rastgele rezervasyon notu döndür
     */
    private function getRandomNote(): ?string
    {
        $notes = [
            null, // Bazı rezervasyonlarda not yok
            null,
            null,
            'Erken check-in talep ediliyor.',
            'Geç check-out gerekli.',
            'Özel diyet ihtiyacı var.',
            'Doğum günü kutlaması için.',
            'Balayı tatili.',
            'İş seyahati.',
            'Aile toplantısı.',
            'Sessiz bir ortam tercih ediliyor.',
            'Havuz kullanımı önemli.',
            'Çocuk dostu ortam gerekli.',
            'Pet-friendly villa arıyoruz.',
            'Deniz manzarası önemli.',
            'Yakın restoran önerileri isteniyor.',
            'Transfer hizmeti gerekli.',
            'Özel temizlik talep ediliyor.',
            'Ekstra havlu ve çarşaf gerekli.',
            'Mutfak malzemeleri tam olsun.',
        ];
        
        return $notes[array_rand($notes)];
    }
}
