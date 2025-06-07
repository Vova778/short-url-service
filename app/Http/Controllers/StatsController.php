<?php

namespace App\Http\Controllers;

use App\Models\Click;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function countries()
    {
        $data = Click::select(
                    DB::raw("COALESCE(country, 'Unknown') AS country"),
                    DB::raw('COUNT(*) AS clicks')
                )
                ->groupBy('country')
                ->orderByDesc('clicks')
                ->get();

        return response()->json($data);
    }

    public function browsers()
    {
        $data = Click::select(
                    DB::raw("COALESCE(browser, 'Unknown') AS browser"),
                    DB::raw('COUNT(*) AS clicks')
                )
                ->groupBy('browser')
                ->orderByDesc('clicks')
                ->get();

        return response()->json($data);
    }

    public function devices()
    {
        $data = Click::select(
                    DB::raw("COALESCE(device, 'Unknown') AS device"),
                    DB::raw('COUNT(*) AS clicks')
                )
                ->groupBy('device')
                ->orderByDesc('clicks')
                ->get();

        return response()->json($data);
    }


    public function referrers()
    {
        $data = Click::select(
                    DB::raw("COALESCE(referrer, 'Direct') AS referrer"),
                    DB::raw('COUNT(*) AS clicks')
                )
                ->groupBy('referrer')
                ->orderByDesc('clicks')
                ->limit(10) 
                ->get();

        return response()->json($data);
    }
}
