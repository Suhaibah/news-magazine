<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        collect([
            ['name' => 'Nasional', 'description' => 'Isu semasa, polisi, dan komuniti.', 'color' => '#dc2626'],
            ['name' => 'Bisnes', 'description' => 'Pasaran, startup, kerja, dan ekonomi.', 'color' => '#047857'],
            ['name' => 'Teknologi', 'description' => 'AI, aplikasi, keselamatan, dan gajet.', 'color' => '#2563eb'],
            ['name' => 'Budaya', 'description' => 'Seni, hiburan, makanan, dan gaya hidup.', 'color' => '#9333ea'],
            ['name' => 'Malaysia', 'description' => 'Berita semasa daripada RSS Google News Malaysia.', 'color' => '#c0262d'],
        ])->each(function (array $category): void {
            Category::query()->updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                $category + ['slug' => Str::slug($category['name'])]
            );
        });
    }
}
