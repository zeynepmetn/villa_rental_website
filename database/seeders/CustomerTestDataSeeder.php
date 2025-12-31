<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Villa;
use App\Models\Booking;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CustomerTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test customer user
        $customer = User::firstOrCreate(
            ['email' => 'customer@test.com'],
            [
                'name' => 'Test Müşteri',
                'password' => Hash::make('password'),
                'phone' => '+90 555 123 45 67',
                'city' => 'İstanbul',
                'birth_date' => '1990-01-01',
                'gender' => 'male',
                'bio' => 'Test müşteri hesabı',
                'notifications_email' => true,
                'notifications_sms' => false,
                'language' => 'tr',
                'currency' => 'TRY',
                'profile_public' => false,
                'show_booking_history' => false,
            ]
        );

        // Assign customer role
        if (!$customer->hasRole('customer')) {
            $customer->assignRole('customer');
        }

        // Get some villas for test bookings
        $villas = Villa::take(3)->get();

        if ($villas->count() > 0) {
            // Create test bookings
            $bookingData = [
                [
                    'villa_id' => $villas[0]->id,
                    'check_in' => Carbon::now()->addDays(30),
                    'check_out' => Carbon::now()->addDays(35),
                    'guests' => 4,
                    'status' => 'confirmed',
                    'total_price' => 15000,
                ],
                [
                    'villa_id' => $villas[1]->id ?? $villas[0]->id,
                    'check_in' => Carbon::now()->subDays(10),
                    'check_out' => Carbon::now()->subDays(5),
                    'guests' => 2,
                    'status' => 'completed',
                    'total_price' => 8000,
                ],
                [
                    'villa_id' => $villas[2] ? $villas[2]->id : $villas[0]->id,
                    'check_in' => Carbon::now()->addDays(60),
                    'check_out' => Carbon::now()->addDays(67),
                    'guests' => 6,
                    'status' => 'pending',
                    'total_price' => 21000,
                ],
            ];

            foreach ($bookingData as $data) {
                Booking::firstOrCreate(
                    [
                        'customer_id' => $customer->id,
                        'villa_id' => $data['villa_id'],
                        'check_in' => $data['check_in'],
                    ],
                    array_merge($data, ['customer_id' => $customer->id])
                );
            }

            // Add some favorites
            if ($villas->count() >= 2) {
                $customer->favorites()->syncWithoutDetaching([
                    $villas[0]->id,
                    $villas[1]->id
                ]);
            }
        }

        $this->command->info('Customer test data created successfully!');
        $this->command->info('Customer login: customer@test.com / password');
    }
}
