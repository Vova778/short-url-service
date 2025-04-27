<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use App\Http\Controllers\Traits\RecordsClicks;
use Illuminate\Support\Facades\Hash;

class LinkRedirectController extends Controller
{
    use RecordsClicks;

    public function redirect($code)
    {
        $link = Link::where('short_code', $code)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->firstOrFail();

        if ($link->password) {
            session()->put('link.password_required', $link->id);
            return view('links.password', compact('link'));
        }

        $this->recordClick($link);

        return redirect()->away($link->original_url);
    }

    public function unlock(Request $request, $code)
    {
        $link = Link::where('short_code', $code)->firstOrFail();

        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->password, $link->password)) {
            return back()->withErrors(__('messages.password_incorrect'));
        }

        session()->forget('link.password_required');

        $this->recordClick($link);

        return redirect()->away($link->original_url);
    }
}
