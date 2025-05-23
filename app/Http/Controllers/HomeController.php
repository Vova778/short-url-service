<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function shorten(Request $request)
    {
        $data = $request->validate([
            'original_url' => 'required|url|max:2048',
            'custom_code' => 'nullable|alpha_num|min:4|max:20',
            'password' => 'nullable|string|min:4|max:100',
            'expires_at' => 'nullable|date|after:now',
        ]);

        if (!$this->isSafeUrl($data['original_url'])) {
            return response()->json([
                'message' => __('home.error_unsafe_url')
            ], 422);
        }

        $code = Link::generateUniqueCode($data['custom_code'] ?? null);

        $link = Link::create([
            'original_url' => $data['original_url'],
            'short_code' => $code,
            'password' => $data['password'] ?? null,
            'expires_at' => $data['expires_at'] ?? null,
            'user_id' => optional($request->user())->id,
        ]);

        return response()->json([
            'short_code' => $code,
            'short_url' => route('links.redirect', $code),
            'expires_at' => $link->expires_at,
            'link_id' => $link->id,
        ]);
    }

    protected function isSafeUrl(string $url): bool
    {
        $apiKey = config('services.safebrowsing.key');

        if (!$apiKey) {
            \Log::warning('Safe Browsing: API key not set, skipping URL check.');
            return true;
        }

        $client = new Client(['base_uri' => 'https://safebrowsing.googleapis.com']);

        try {
            $response = $client->post("/v4/threatMatches:find?key={$apiKey}", [
                'json' => [
                    'client' => [
                        'clientId' => 'short-url-service',
                        'clientVersion' => '1.0.0',
                    ],
                    'threatInfo' => [
                        'threatTypes' => ['MALWARE', 'SOCIAL_ENGINEERING', 'UNWANTED_SOFTWARE'],
                        'platformTypes' => ['ANY_PLATFORM'],
                        'threatEntryTypes' => ['URL'],
                        'threatEntries' => [['url' => $url]],
                    ],
                ],
            ]);
        } catch (GuzzleException $e) {
            \Log::error('Safe Browsing API error: ' . $e->getMessage());
            return true;
        }

        $body = json_decode($response->getBody(), true);
        return empty($body['matches'] ?? []);
    }
}
