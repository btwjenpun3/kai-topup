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
    }
}
