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

        /**
         * Product
         */

        \App\Models\Game::create([
            'nama' => 'Mobile Legend',
            'kode' => 'ml',
            'brand' => 'MOBILE LEGENDS',
            'url_gambar' => 'games/mobile-legend.webp',
            'slug' => 'mobile-legend'
        ]);
        
        \App\Models\Game::create([
            'nama' => 'Free Fire',
            'kode' => 'ff',
            'brand' => 'FREE FIRE',
            'url_gambar' => 'games/freefire.webp',
            'slug' => 'free-fire'
        ]); 

        \App\Models\Game::create([
            'nama' => 'Undawn',
            'kode' => 'ud',
            'brand' => 'Undawn',
            'url_gambar' => 'games/undawn.webp',
            'slug' => 'undawn'
        ]); 
        
        // \App\Models\Harga::create([
        //     'game_id' => 1,
        //     'nama_produk' => '5 (5+0) Diamonds',
        //     'kode_produk' => '0001',
        //     'gambar' => 'produk/wb9lgambXZ-diamond.webp',
        //     'modal' => 1250,
        //     'harga_jual' => 1275,
        //     'profit' => 25,
        //     'status' => 1
        // ]); 

        // \App\Models\Harga::create([
        //     'game_id' => 1,
        //     'nama_produk' => '10 (9+1) Diamonds',
        //     'kode_produk' => '0002',
        //     'gambar' => 'produk/wb9lgambXZ-diamond.webp',
        //     'modal' => 2250,
        //     'harga_jual' => 2275,
        //     'profit' => 25,
        //     'status' => 1
        // ]); 

        // \App\Models\Harga::create([
        //     'game_id' => 1,
        //     'nama_produk' => '100 (95+5) Diamonds',
        //     'kode_produk' => '0003',
        //     'gambar' => 'produk/wb9lgambXZ-diamond.webp',
        //     'modal' => 12250,
        //     'harga_jual' => 12275,
        //     'profit' => 25,
        //     'status' => 1
        // ]); 

        /**
         * Payment
         */

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

        \App\Models\Payment::create([
            'name' => 'VA BCA',
            'payment_type' => 'VA',
            'payment_method' => 'BCA',
            'admin_fee_fixed' => 4440,
            'image' => 'payment/bca.webp',
            'status' => 1
        ]);

        \App\Models\Payment::create([
            'name' => 'VA BNI',
            'payment_type' => 'VA',
            'payment_method' => 'BNI',
            'admin_fee_fixed' => 4440,
            'image' => 'payment/bni.webp',
            'status' => 1
        ]);

        \App\Models\Payment::create([
            'name' => 'VA BRI',
            'payment_type' => 'VA',
            'payment_method' => 'BRI',
            'admin_fee_fixed' => 4440,
            'image' => 'payment/bri.webp',
            'status' => 1
        ]);

        \App\Models\Payment::create([
            'name' => 'VA BJB',
            'payment_type' => 'VA',
            'payment_method' => 'BJB',
            'admin_fee_fixed' => 4440,
            'image' => 'payment/bjb.webp',
            'status' => 1
        ]);

        \App\Models\Payment::create([
            'name' => 'VA BSI',
            'payment_type' => 'VA',
            'payment_method' => 'BSI',
            'admin_fee_fixed' => 4440,
            'image' => 'payment/bsi.webp',
            'status' => 1
        ]);

        \App\Models\Payment::create([
            'name' => 'Alfamart',
            'payment_type' => 'OUTLET',
            'payment_method' => 'ALFAMART',
            'admin_fee_fixed' => 5550,
            'image' => 'payment/alfamart.webp',
            'status' => 1
        ]);

        \App\Models\Payment::create([
            'name' => 'Indomaret',
            'payment_type' => 'OUTLET',
            'payment_method' => 'INDOMARET',
            'admin_fee_fixed' => 5550,
            'image' => 'payment/indomaret.webp',
            'status' => 1
        ]);
    }
}
