<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    public function run(): void
    {
        $platforms = [
            ['name' => 'Steam', 'slug' => 'steam'],
            ['name' => 'Epic Games', 'slug' => 'epic'],
            ['name' => 'PlayStation', 'slug' => 'playstation'],
            ['name' => 'Xbox', 'slug' => 'xbox'],
            ['name' => 'Nintendo Switch', 'slug' => 'nintendo-switch'],
            ['name' => 'GOG', 'slug' => 'gog'],
            ['name' => 'Riot Games', 'slug' => 'riot'],
            ['name' => 'HoyoLab', 'slug' => 'hoyolab'],
            ['name' => 'Battle.net', 'slug' => 'battlenet'],
            ['name' => 'EA App', 'slug' => 'ea'],
        ];

        foreach ($platforms as $platform) {
            Platform::updateOrCreate(
                ['slug' => $platform['slug']],
                ['name' => $platform['name']]
            );
        }

        $this->command->info('✅ Plataformas creadas correctamente');
    }
}