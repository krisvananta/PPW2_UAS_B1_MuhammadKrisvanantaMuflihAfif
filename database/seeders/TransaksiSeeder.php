<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $startDate = Carbon::create(2024, 11, 1); // startDate = 2024-11-01
        $endDate = Carbon::create(2024, 11, 10); // endDate = 2024-11-10

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $numberOfTransactions = $faker->numberBetween(15, 20); // gunakan faker untuk membuat angka antara 15 - 20

            for ($i = 0; $i < $numberOfTransactions; $i++) {
                Transaksi::create([
                    'tanggal_pembelian' => $date->format('Y-m-d'),
                    'total_harga' => 0,
                    'bayar' => 0,
                    'kembalian' => 0,
                ]);
            }
        }
    }
}
