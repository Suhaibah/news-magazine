<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class RssController extends Controller
{
    public function import(Request $request): RedirectResponse
    {
        $limit = max(1, min(30, (int) $request->input('limit', 10)));
        $exitCode = Artisan::call('news:import-rss', [
            '--all' => true,
            '--limit' => $limit,
        ]);

        $output = trim(Artisan::output());

        if ($exitCode !== 0) {
            return back()->withErrors($output ?: 'Import RSS gagal. Cuba semak sambungan internet atau RSS feed.');
        }

        return back()->with('status', $output ?: 'Import RSS selesai.');
    }

    public function cleanup(Request $request): RedirectResponse
    {
        $keep = max(10, min(500, (int) $request->input('keep', config('services.news.max_posts', 100))));
        $exitCode = Artisan::call('news:cleanup', [
            '--keep' => $keep,
        ]);

        $output = trim(Artisan::output());

        if ($exitCode !== 0) {
            return back()->withErrors($output ?: 'Cleanup artikel gagal.');
        }

        return back()->with('status', $output ?: 'Cleanup selesai.');
    }
}
