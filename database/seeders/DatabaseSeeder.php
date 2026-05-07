<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = collect([
            ['name' => 'Nasional', 'description' => 'Isu semasa, polisi, dan komuniti.', 'color' => '#dc2626'],
            ['name' => 'Bisnes', 'description' => 'Pasaran, startup, kerja, dan ekonomi.', 'color' => '#047857'],
            ['name' => 'Teknologi', 'description' => 'AI, aplikasi, keselamatan, dan gajet.', 'color' => '#2563eb'],
            ['name' => 'Budaya', 'description' => 'Seni, hiburan, makanan, dan gaya hidup.', 'color' => '#9333ea'],
        ])->mapWithKeys(function (array $category) {
            $model = Category::query()->updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                $category + ['slug' => Str::slug($category['name'])]
            );

            return [$model->name => $model];
        });

        $posts = [
            [
                'category' => 'Nasional',
                'title' => 'Bandar Pintar Mula Uji Laluan Bas Elektrik Waktu Puncak',
                'excerpt' => 'Program rintis baharu memberi fokus kepada ketepatan masa, pelepasan karbon rendah, dan sambungan transit yang lebih lancar.',
                'author' => 'Aina Rahman',
                'image_url' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=1400&q=80',
                'is_featured' => true,
                'views_count' => 1840,
                'published_at' => Carbon::now()->subHours(2),
            ],
            [
                'category' => 'Teknologi',
                'title' => 'Syarikat Tempatan Perkenal Platform AI Untuk Editor Berita',
                'excerpt' => 'Alat editorial ini membantu menyusun ringkasan, menyemak fakta dalaman, dan mencadangkan tajuk tanpa menggantikan keputusan editor.',
                'author' => 'Daniel Lim',
                'image_url' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=900&q=80',
                'views_count' => 1320,
                'published_at' => Carbon::now()->subHours(4),
            ],
            [
                'category' => 'Bisnes',
                'title' => 'PKS Digital Catat Jualan Lebih Kukuh Melalui Kempen Mikro',
                'excerpt' => 'Peniaga kecil semakin memilih data pelanggan dan promosi bersasar berbanding kempen besar yang sukar diukur.',
                'author' => 'Mira Iskandar',
                'image_url' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=900&q=80',
                'views_count' => 970,
                'published_at' => Carbon::now()->subHours(7),
            ],
            [
                'category' => 'Budaya',
                'title' => 'Kafe Buku Lama Hidup Semula Sebagai Ruang Komuniti Kreatif',
                'excerpt' => 'Gabungan bacaan puisi, muzik kecil, dan bengkel zine menarik pengunjung muda ke deretan kedai lama hujung minggu ini.',
                'author' => 'Sofia Azmi',
                'image_url' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=900&q=80',
                'views_count' => 760,
                'published_at' => Carbon::now()->subDay(),
            ],
            [
                'category' => 'Nasional',
                'title' => 'Panel Pendidikan Cadang Modul Literasi Media Di Sekolah',
                'excerpt' => 'Cadangan itu menekankan kemahiran membaca sumber, mengenal manipulasi visual, dan memahami konteks berita.',
                'author' => 'Nadia Zulkifli',
                'image_url' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=900&q=80',
                'views_count' => 540,
                'published_at' => Carbon::now()->subDays(2),
            ],
            [
                'category' => 'Teknologi',
                'title' => 'Aplikasi Kesihatan Baharu Fokus Rekod Harian Yang Ringkas',
                'excerpt' => 'Pembangun memilih pengalaman yang rendah gangguan dengan carta kecil dan peringatan yang boleh dilaras.',
                'author' => 'Irfan Hakim',
                'image_url' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=900&q=80',
                'views_count' => 420,
                'published_at' => Carbon::now()->subDays(3),
            ],
        ];

        foreach ($posts as $post) {
            Post::query()->updateOrCreate(
                ['slug' => Str::slug($post['title'])],
                [
                    'category_id' => $categories[$post['category']]->id,
                    'title' => $post['title'],
                    'slug' => Str::slug($post['title']),
                    'excerpt' => $post['excerpt'],
                    'body' => $post['excerpt']."\n\nLaporan penuh sedang dikemas kini oleh meja editorial MetroPress dengan latar belakang, reaksi pembaca, dan data sokongan.",
                    'author' => $post['author'],
                    'image_url' => $post['image_url'],
                    'is_featured' => $post['is_featured'] ?? false,
                    'views_count' => $post['views_count'],
                    'published_at' => $post['published_at'],
                ]
            );
        }
    }
}
