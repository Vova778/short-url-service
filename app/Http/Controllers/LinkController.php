<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LinkController extends Controller
{
    // Список користувача
    public function index(Request $request)
    {
        $links = Link::where('user_id', $request->user()->id)
                     ->latest()->paginate(10);
        return view('dashboard.index', compact('links'));
    }

    // Форма створення
    public function create()
    {
        return view('links.create');
    }

    // Зберегти нове з параметрами
    public function store(Request $request)
    {
        $data = $request->validate([
            'original_url' => 'required|url|max:2048',
            'expires_at'   => 'nullable|date|after:now',
            'password'     => 'nullable|string|min:6|max:60',
        ]);

        // Унікальний код
        do {
            $code = Str::random(6);
        } while (Link::where('short_code', $code)->exists());

        $data['short_code'] = $code;
        $data['user_id']    = $request->user()->id;
        if ($data['password']) {
            $data['password'] = bcrypt($data['password']);
        }

        $link = Link::create($data);

        return redirect()->route('links.show', $link)
                         ->with('status', __('messages.link_created'));
    }

    // Перегляд деталей
    public function show(Link $link)
    {
        $this->authorize('view', $link);
        $clicks = $link->clicks()->latest()->get();
        return view('links.show', compact('link','clicks'));
    }

    // Форма редагування
    public function edit(Link $link)
    {
        $this->authorize('update', $link);
        return view('links.edit', compact('link'));
    }

    // Оновити
    public function update(Request $request, Link $link)
    {
        $this->authorize('update', $link);

        $data = $request->validate([
            'original_url' => 'required|url|max:2048',
            'expires_at'   => 'nullable|date|after:now',
            'password'     => 'nullable|string|min:6|max:60',
        ]);
        if ($data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }
        $link->update($data);

        return back()->with('status', __('messages.link_updated'));
    }

    // Видалити
    public function destroy(Link $link)
    {
        $this->authorize('delete', $link);
        $link->delete();
        return redirect()->route('dashboard')
                         ->with('status', __('messages.link_deleted'));
    }

    public function redirect($code)
    {
        $link = Link::where('short_code', $code)
            ->where(function($q){
                $q->whereNull('expires_at')
                  ->orWhere('expires_at','>', now());
            })->firstOrFail();

        if ($link->password) {
            session()->put("link.password_required", $link->id);
            return view('links.password', compact('link'));
        }

        $this->recordClick($link);
        return redirect()->away($link->original_url);
    }

    public function unlock(Request $request, $code)
    {
        $link = Link::where('short_code', $code)->firstOrFail();
        $request->validate(['password'=>'required']);
        if (!\Hash::check($request->password, $link->password)) {
            return back()->withErrors(__('messages.password_incorrect'));
        }
        session()->forget("link.password_required");
        $this->recordClick($link);
        return redirect()->away($link->original_url);
    }

    protected function recordClick(Link $link)
    {
        $link->clicks()->create([
            'clicked_at' => now(),
            'referrer'   => request()->headers->get('referer'),
            'ip_address' => request()->ip(),
        ]);
    }
}
