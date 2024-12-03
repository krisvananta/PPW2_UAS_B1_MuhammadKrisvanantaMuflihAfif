<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Bezhanov\Faker\Provider\Commerce;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TransaksiDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $faker->addProvider(new Commerce($faker));

        $transaksi = Transaksi::all();

        foreach ($transaksi as $t) {
            $numberOfDetails = $faker->numberBetween(5, 15); // gunakan faker untuk membuat angka antara 5 - 15
            $total_harga = 0;

            for ($j = 0; $j < $numberOfDetails; $j++) {
                $hargaSatuan = $faker->numberBetween(10, 500) * 100;
                $jumlah = $faker->numberBetween(1, 5);
                $subtotal = $hargaSatuan * $jumlah;
                $total_harga += $subtotal;

                TransaksiDetail::create([
                    'id_transaksi' => $t->id,
                    'nama_produk' => $faker->productName,
                    'harga_satuan' => $hargaSatuan,
                    'jumlah' => $jumlah,
                    'subtotal' => $subtotal,
                ]);
            }

            $t->total_harga = $total_harga;
            $t->bayar = ceil($total_harga/50000) * 50000;
            $t->kembalian = $t->bayar - $total_harga;
            $t->save();
        }
    }
}
