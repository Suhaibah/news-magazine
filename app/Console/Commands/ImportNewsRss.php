<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleXMLElement;

class ImportNewsRss extends Command
{
    protected $signature = 'news:import-rss
        {url? : RSS feed URL}
        {--category=Malaysia : Category name for imported news}
        {--limit=15 : Maximum items to import per feed}
        {--all : Import every configured feed}';

    protected $description = 'Import Malaysia news from RSS and save available images locally.';

    public function handle(): int
    {
        if ($this->option('all') || ! $this->argument('url')) {
            return $this->importConfiguredFeeds();
        }

        return $this->importFeed(
            (string) $this->argument('url'),
            (string) $this->option('category'),
            max(1, (int) $this->option('limit'))
        );
    }

    private function importConfiguredFeeds(): int
    {
        $feeds = config('services.news.feeds', []);
        $status = self::SUCCESS;

        foreach ($feeds as $feed) {
            $result = $this->importFeed($feed['url'], $feed['name'], max(1, (int) $this->option('limit')));

            if ($result !== self::SUCCESS) {
                $status = self::FAILURE;
            }
        }

        return $status;
    }

    private function importFeed(string $url, string $categoryName, int $limit): int
    {
        $category = Category::query()->firstOrCreate(
            ['slug' => Str::slug($categoryName)],
            [
                'name' => $categoryName,
                'description' => 'Berita semasa diimport melalui RSS.',
                'color' => '#c0262d',
            ]
        );

        try {
            $response = Http::timeout(25)->get($url);
        } catch (\Throwable $exception) {
            $this->error('RSS gagal dimuat turun: '.$exception->getMessage());

            return self::FAILURE;
        }

        if (! $response->successful()) {
            $this->error("RSS gagal dimuat turun: HTTP {$response->status()}");

            return self::FAILURE;
        }

        $xml = simplexml_load_string($response->body(), SimpleXMLElement::class, LIBXML_NOCDATA);

        if (! $xml || ! isset($xml->channel->item)) {
            $this->error('RSS tidak sah atau tiada item berita.');

            return self::FAILURE;
        }

        $imported = 0;

        foreach ($xml->channel->item as $item) {
            if ($imported >= $limit) {
                break;
            }

            $title = trim((string) $item->title);
            $sourceUrl = trim((string) $item->link);

            if ($title === '' || $sourceUrl === '') {
                continue;
            }

            $description = trim((string) $item->description);
            $excerpt = $this->cleanText($description) ?: $title;
            $imageUrl = $this->imageUrlFromItem($item, $description) ?: $this->imageUrlFromPage($sourceUrl);
            $imagePath = $imageUrl ? $this->saveImage($imageUrl) : null;

            Post::query()->updateOrCreate(
                ['source_url' => $sourceUrl],
                [
                    'category_id' => $category->id,
                    'title' => $title,
                    'slug' => $this->uniqueSlug($title, $sourceUrl),
                    'excerpt' => Str::limit($excerpt, 500),
                    'body' => $excerpt."\n\nSumber asal: {$sourceUrl}",
                    'author' => $this->sourceName($item) ?: 'Google News Malaysia',
                    'image_url' => $imageUrl ?: '',
                    'image_path' => $imagePath,
                    'is_featured' => $imported === 0,
                    'views_count' => max(50, 1200 - ($imported * 80)),
                    'published_at' => $this->publishedAt($item),
                ]
            );

            $imported++;
        }

        $this->info("Import {$categoryName} selesai: {$imported} artikel.");

        return self::SUCCESS;
    }

    private function cleanText(string $html): string
    {
        return trim(html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }

    private function imageUrlFromItem(SimpleXMLElement $item, string $description): ?string
    {
        $media = $item->children('media', true);

        if (isset($media->content)) {
            $attributes = $media->content->attributes();
            if (isset($attributes['url'])) {
                return (string) $attributes['url'];
            }
        }

        if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $description, $matches)) {
            return html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        return null;
    }

    private function imageUrlFromPage(string $url): ?string
    {
        try {
            $response = Http::timeout(15)->get($url);

            if (! $response->successful()) {
                return null;
            }

            if (preg_match('/<meta\s+property=["\']og:image["\']\s+content=["\']([^"\']+)["\']/i', $response->body(), $matches)) {
                return html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            }
        } catch (\Throwable) {
            return null;
        }

        return null;
    }

    private function saveImage(string $url): ?string
    {
        try {
            $response = Http::timeout(20)->get($url);
            $contentType = (string) $response->header('Content-Type');

            if (! $response->successful() || ! str_starts_with($contentType, 'image/')) {
                return null;
            }

            $extension = match (strtolower(strtok($contentType, ';'))) {
                'image/png' => 'png',
                'image/webp' => 'webp',
                'image/gif' => 'gif',
                default => 'jpg',
            };

            $path = 'rss/'.Str::uuid().'.'.$extension;
            Storage::disk('public')->put($path, $response->body());

            return $path;
        } catch (\Throwable) {
            return null;
        }
    }

    private function sourceName(SimpleXMLElement $item): ?string
    {
        return isset($item->source) ? trim((string) $item->source) : null;
    }

    private function publishedAt(SimpleXMLElement $item): Carbon
    {
        $date = trim((string) $item->pubDate);

        return $date ? Carbon::parse($date) : now();
    }

    private function uniqueSlug(string $title, string $sourceUrl): string
    {
        $base = Str::slug($title) ?: 'news';
        $slug = $base;
        $counter = 2;

        while (Post::query()->where('slug', $slug)->where('source_url', '!=', $sourceUrl)->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
