<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Str;

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
        ]);

        do {
            $code = Str::random(6);
        } while (Link::where('short_code', $code)->exists());

        $link = Link::create([
            'original_url' => $data['original_url'],
            'short_code'   => $code,
        ]);

        return response()->json([
            'short_code' => $code,
            'short_url'  => route('links.redirect', $code),
        ]);
    }
}
