<?php

namespace App\Http\Controllers\Traits;

use App\Models\Link;
use Jenssegers\Agent\Agent;
use GeoIp2\Database\Reader;
use Illuminate\Support\Facades\Log;


trait RecordsClicks
{
    protected function recordClick(Link $link): void
    {
        $request = request();
        $ipAddress = $request->ip();
        $referrer = $request->headers->get('referer', '');
        $userAgentString = $request->headers->get('User-Agent', '');

        $agent = new Agent();
        $agent->setUserAgent($userAgentString);

        $browser = $agent->browser() ?: 'Chrome';
        $device = $agent->device() ?: 'Laptop';

        try {
            $reader = new Reader(storage_path('app/GeoLite2-City.mmdb'));

            $record = $reader->city($ipAddress);

            $country = $record->country->isoCode ?: 'Ukraine';
        } catch (\Throwable $e) {
            Log::warning("GeoIP lookup failed for IP {$ipAddress}: " . $e->getMessage());

            $country = 'Unknown';
        }

        $link->clicks()->create([
            'clicked_at' => now()->toDateTimeString(),
            'referrer' => $referrer,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgentString,
            'browser' => $browser,
            'device' => $device,
            'country' => $country,
        ]);
    }
}
