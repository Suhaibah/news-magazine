<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupOldNews extends Command
{
    protected $signature = 'news:cleanup {--keep= : Number of latest posts to keep}';

    protected $description = 'Delete old RSS news posts and their local images.';

    public function handle(): int
    {
        $keep = (int) ($this->option('keep') ?: config('services.news.max_posts', 100));
        $keep = max(1, $keep);

        $idsToKeep = Post::query()
            ->latest('published_at')
            ->limit($keep)
            ->pluck('id');

        $oldPosts = Post::query()
            ->whereNotIn('id', $idsToKeep)
            ->whereNotNull('source_url')
            ->get();

        foreach ($oldPosts as $post) {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }

            $post->delete();
        }

        $this->info("Cleanup selesai: {$oldPosts->count()} artikel lama dipadam. Simpan {$keep} artikel terbaru.");

        return self::SUCCESS;
    }
}
