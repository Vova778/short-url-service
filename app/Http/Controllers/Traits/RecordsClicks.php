<?php

namespace App\Http\Controllers\Traits;

use App\Models\Link;

trait RecordsClicks
{
    protected function recordClick(Link $link)
    {
        $link->clicks()->create([
            'clicked_at' => now(),
            'referrer'   => request()->headers->get('referer'),
            'ip_address' => request()->ip(),
        ]);
    }
}
