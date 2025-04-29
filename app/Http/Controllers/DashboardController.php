<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalLinks = $user->links()->count();


        $totalClicks = $user->links()
            ->withCount('clicks')
            ->get()
            ->sum('clicks_count');

        $linkIds = $user->links()->pluck('id');
        $todayClicks = \App\Models\Click::whereIn('link_id', $linkIds)
            ->whereDate('clicked_at', Carbon::today())
            ->count();

        $links = $user->links()
            ->withCount('clicks')
            ->latest()
            ->paginate(10);

        return view('dashboard.index', compact(
            'totalLinks',
            'totalClicks',
            'todayClicks',
            'links'
        ));
    }
}
