<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Str;
use App\Http\Controllers\Traits\RecordsClicks;

class ShortLinkController extends Controller
{
    use RecordsClicks;

    public function create()
    {
        return view('links.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'original_url' => 'required|url|max:2048',
            'expires_at' => 'nullable|date|after:now',
            'password' => 'nullable|string|min:6|max:60',
        ]);

        do {
            $code = Str::random(6);
        } while (Link::where('short_code', $code)->exists());

        $data['short_code'] = $code;
        $data['user_id'] = $request->user()->id;
        if ($data['password']) {
            $data['password'] = bcrypt($data['password']);
        }

        $link = Link::create($data);

        return redirect()
            ->route('links.show', $link)
            ->with('status', __('messages.link_created'));
    }

    public function show(Link $link)
    {
        $this->authorize('view', $link);
        $clicks = $link->clicks()->latest('clicked_at')->get();

        return view('links.show', compact('link', 'clicks'));
    }

    public function edit(Link $link)
    {
        $this->authorize('update', $link);

        return view('links.edit', compact('link'));
    }

    public function update(Request $request, Link $link)
    {
        $this->authorize('update', $link);

        $data = $request->validate([
            'original_url' => 'required|url|max:2048',
            'expires_at' => 'nullable|date|after:now',
            'password' => 'nullable|string|min:6|max:60',
        ]);

        if ($data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $link->update($data);

        return back()->with('status', __('messages.link_updated'));
    }

    public function destroy(Link $link)
    {
        $this->authorize('delete', $link);
        $link->delete();

        return redirect()
            ->route('dashboard')
            ->with('status', __('messages.link_deleted'));
    }
}
