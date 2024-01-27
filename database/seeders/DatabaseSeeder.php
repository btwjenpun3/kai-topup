<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\Game::create([
            'nama' => 'Mobile Legend',
            'kode' => 'ml',
            'url_gambar' => 'games/mobile-legend.webp',
            'slug' => 'mobile-legend'
        ]);   
        
        \App\Models\Harga::create([
            'game_id' => 1,
            'nama_produk' => '5 (5+0) Diamonds',
            'kode_produk' => '0001',
            'gambar' => 'produk/wb9lgambXZ-diamond.webp',
            'modal' => 1250,
            'harga_jual' => 1275,
            'profit' => 25,
            'status' => 1
        ]); 

        \App\Models\Harga::create([
            'game_id' => 1,
            'nama_produk' => '10 (9+1) Diamonds',
            'kode_produk' => '0002',
            'gambar' => 'produk/wb9lgambXZ-diamond.webp',
            'modal' => 2250,
            'harga_jual' => 2275,
            'profit' => 25,
            'status' => 1
        ]); 

        \App\Models\Payment::create([
            'name' => 'DANA',
            'payment_type' => 'EWALLET',
            'payment_method' => 'ID_DANA',
            'admin_fee' => 2,
            'image' => 'payment/dana.webp',
            'status' => 1
        ]); 

        \App\Models\Payment::create([
            'name' => 'Shopee Pay',
            'payment_type' => 'EWALLET',
            'payment_method' => 'ID_SHOPEEPAY',
            'admin_fee' => 4,
            'image' => 'payment/shopeepay.webp',
            'status' => 1
        ]);

        \App\Models\Payment::create([
            'name' => 'LinkAja',
            'payment_type' => 'EWALLET',
            'payment_method' => 'ID_LINKAJA',
            'admin_fee' => 4,
            'image' => 'payment/linkaja.webp',
            'status' => 1
        ]);

        \App\Models\Payment::create([
            'name' => 'AstraPay',
            'payment_type' => 'EWALLET',
            'payment_method' => 'ID_ASTRAPAY',
            'admin_fee' => 2,
            'image' => 'payment/astrapay.webp',
            'status' => 1
        ]);

        \App\Models\Payment::create([
            'name' => 'QRIS',
            'payment_type' => 'QRIS',
            'payment_method' => 'QRIS',
            'admin_fee' => 0.8,
            'image' => 'payment/qris.webp',
            'status' => 1
        ]);
    }
}
