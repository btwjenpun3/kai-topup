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

        \App\Models\Role::create([
            'name' => 'admin',
            'description' => 'Administrator'
        ]);

        \App\Models\User::create([
            'role_id' => 1,
            'name' => 'Muhamad Helmi',
            'email' => 'muhamadkelmi@gmail.com',
            'phone' => '6285740196222',
            'password' => bcrypt('Kelmi!@#')
        ]);

        /**
         * Product
         */

        \App\Models\Game::create([
            'nama' => 'Mobile Legend',
            'kode' => 'ml',
            'kategori' => 'Games',
            'brand' => 'MOBILE LEGENDS',
            'url_gambar' => 'games/mobile-legend.webp',
            'slug' => 'mobile-legend'
        ]);
        
        \App\Models\Game::create([
            'nama' => 'Free Fire',
            'kode' => 'ff',
            'kategori' => 'Games',
            'brand' => 'FREE FIRE',
            'url_gambar' => 'games/freefire.webp',
            'slug' => 'free-fire'
        ]); 

        \App\Models\Game::create([
            'nama' => 'Undawn',
            'kode' => 'ud',
            'kategori' => 'Games',
            'brand' => 'Undawn',
            'url_gambar' => 'games/undawn.webp',
            'slug' => 'undawn'
        ]); 

        \App\Models\Game::create([
            'nama' => 'LifeAfter',
            'kode' => 'la',
            'kategori' => 'Games',
            'brand' => 'LifeAfter Credits',
            'url_gambar' => 'games/lifeafter.webp',
            'slug' => 'lifeafter'
        ]);

        \App\Models\Game::create([
            'nama' => 'PLN',
            'kode' => 'pln',
            'kategori' => 'Listrik',
            'brand' => 'PLN',
            'url_gambar' => 'games/pln.webp',
            'slug' => 'pln'
        ]);

        \App\Models\Game::create([
            'nama' => 'PUBG Mobile Indonesia',
            'kode' => 'pubg',
            'kategori' => 'Games',
            'brand' => 'PUBG MOBILE',
            'url_gambar' => 'games/pubg.webp',
            'slug' => 'pubg'
        ]);               

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

        \App\Models\Payment::create([
            'name' => 'Realm',
            'payment_type' => 'REALM',
            'payment_method' => 'REALM',
            'admin_fee_fixed' => 0,
            'image' => 'payment/indomaret.webp',
            'status' => 0
        ]);
    }
}
