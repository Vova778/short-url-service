<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Link;
use Carbon\Carbon;

class CleanupLinks extends Command
{
    protected $signature = 'links:cleanup';
    protected $description = 'Delete expired or unsafe links';
    public function handle(): int
    {
        $now = Carbon::now();
        $expired = $unsafe = 0;
        Link::chunk(100, function ($links)
            use ($now, &$expired, &$unsafe) {
            foreach ($links as $link) {
                try {
                    if ($link->expires_at && $link->expires_at->lt($now)) {
                        $link->delete();
                        $expired++;
                        continue;
                    }

                    if ($this->isUnsafe($link->original_url)) {
                        $link->delete();
                        $unsafe++;
                    }
                } catch (\Throwable $e) {
                    Log::error("Cleanup failed for link {$link->id}: {$e->getMessage()}");
                }
            }
        });

        $this->info("Done. Expired: {$expired}, Unsafe: {$unsafe}.");
        return 0;
    }

    protected function isUnsafe(string $url): bool
    {
        $key = config('services.safebrowsing.key');
        if (!$key) {
            return false;
        }

        $resp = Http::post("https://safebrowsing.googleapis.com/v4/threatMatches:find?key={$key}", [
            'client' => ['clientId' => config('app.name'), 'clientVersion' => '1.0'],
            'threatInfo' => [
                'threatTypes' => ['MALWARE', 'SOCIAL_ENGINEERING'],
                'platformTypes' => ['ANY_PLATFORM'],
                'threatEntryTypes' => ['URL'],
                'threatEntries' => [['url' => $url]],
            ],
        ]);

        if ($resp->ok() && !empty($resp->json('matches'))) {
            Log::warning("Unsafe link deleted: {$url}");
            return true;
        }

        return false;
    }
}
