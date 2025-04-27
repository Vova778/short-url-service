<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Str;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function shorten(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url|max:2048',
        ]);

        // Генеруємо унікальний код
        do {
            $code = Str::random(6);
        } while (Link::where('short_code', $code)->exists());

        $link = Link::create([
            'original_url' => $request->original_url,
            'short_code'   => $code,
            'expires_at'   => null,
            'password'     => null,
        ]);

        return response()->json($link->only('short_code'));
    }
}
