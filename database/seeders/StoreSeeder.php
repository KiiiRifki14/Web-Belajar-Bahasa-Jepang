<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // Power-ups
            [
                'name' => 'Streak Shield',
                'type' => 'powerup',
                'price' => 250,
                'description' => 'Protects your streak from one wrong answer. Automatically consumed upon a mistake.',
                'image_path' => 'items/streak_shield.png'
            ],
            [
                'name' => 'Kopi Begadang',
                'type' => 'powerup',
                'price' => 150,
                'description' => 'Adds extra time for complex questions. (Focus +10)',
                'image_path' => 'items/coffee.png'
            ],

            // Cosmetics
            [
                'name' => 'Baju Kantoran',
                'type' => 'skin',
                'price' => 500,
                'description' => 'A sharp tie and suitcase for the hardworking Neko.',
                'image_path' => 'items/skin_office.png'
            ],
            [
                'name' => 'Baju Samurai',
                'type' => 'skin',
                'price' => 1200,
                'description' => 'Traditional armor for the legendary warrior.',
                'image_path' => 'items/skin_samurai.png'
            ],
            [
                'name' => 'Kimono Sakura',
                'type' => 'skin',
                'price' => 800,
                'description' => 'Beautiful floral garment for a peaceful study session.',
                'image_path' => 'items/skin_kimono.png'
            ],

            // Gacha
            [
                'name' => 'O-mikuji Ticket',
                'type' => 'gacha_ticket',
                'price' => 100,
                'description' => 'A ticket to draw a random fortune at the shrine.',
                'image_path' => 'items/gacha_ticket.png'
            ],
        ];

        foreach ($items as $item) {
            Item::updateOrCreate(['name' => $item['name']], $item);
        }
    }
}
