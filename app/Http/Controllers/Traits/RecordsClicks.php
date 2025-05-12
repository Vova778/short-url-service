<?php

namespace App\Http\Controllers\Traits;

use App\Models\Link;
use Http;
use Log;

trait RecordsClicks
{
    protected function recordClick(Link $link)
    {
        $link->clicks()->create([
            'clicked_at' => now(),
            'referrer' => request()->headers->get('referer'),
            'ip_address' => request()->ip(),
        ]);
    }

    // protected function recordClick(Link $link): void
    // {
    //     $request = request();
    //     $ipAddress = $request->ip();
    //     $referrer = $request->headers->get('referer', '');
    //     $userAgentString = $request->headers->get('User-Agent', '');

    //     $agent = new Agent();
    //     $agent->setUserAgent($userAgentString);
    //     $browser = $agent->browser();

    //     try {
    //         $reader = new \GeoIp2\Database\Reader(storage_path('app/GeoLite2-City.mmdb'));
    //         $record = $reader->city($ipAddress);
    //         $country = $record->country->isoCode ?: 'Unknown';
    //     } catch (\Throwable $e) {
    //         \Log::warning("GeoIP lookup failed for IP {$ipAddress}: " . $e->getMessage());
    //         $country = 'Unknown';
    //     }

    //     $link->clicks()->create([
    //         'clicked_at' => now()->toDateTimeString(),
    //         'referrer' => $referrer,
    //         'ip_address' => $ipAddress,
    //         'user_agent' => $userAgentString,
    //         'browser' => $browser,
    //         'country' => $country,
    //     ]);
    // }
}
