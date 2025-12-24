<?php

namespace App\Http\Controllers;

use App\Models\President;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PresidentController extends Controller
{
    public function index(Request $request)
    {
        $selectedUser = null;

        $query = President::with('user');

        if ($request->filled('username')) {
            $selectedUser = User::where('username', $request->username)->firstOrFail();
            $query->where('user_id', $selectedUser->id);
        }

        if (auth()->check() && $request->boolean('with_trashed')) {
            if (
                auth()->user()->is_admin ||
                ($selectedUser && auth()->id() === $selectedUser->id)
            ) {
                $query->withTrashed();
            }
        }

        $presidents = $query->latest()->get();

        return view('presidents.index', compact('presidents', 'selectedUser'));
    }

    public function create()
    {
        return view('presidents.create');
    }

    public function show(President $president)
    {
        return view('presidents.show', compact('president'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_ru' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string', 'max:500'],
            'full_description' => ['nullable', 'string'],
            'term_start' => ['required', 'date'],
            'term_end' => ['nullable', 'date', 'after_or_equal:term_start'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $data['slug'] = Str::slug($data['name_en']) . '-' . time();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('presidents', 'public');
        }

        President::create($data);

        return redirect()
            ->route('presidents.index')
            ->with('success', 'Президент добавлен');
    }

    public function edit(President $president)
    {
        abort_unless(
            auth()->id() === $president->user_id || auth()->user()->is_admin,
            403
        );

        return view('presidents.edit', compact('president'));
    }

    public function update(Request $request, President $president)
    {
        abort_unless(
            auth()->id() === $president->user_id || auth()->user()->is_admin,
            403
        );

        $data = $request->validate([
            'name_ru' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string', 'max:500'],
            'full_description' => ['nullable', 'string'],
            'term_start' => ['required', 'date'],
            'term_end' => ['nullable', 'date', 'after_or_equal:term_start'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($president->image_path) {
                Storage::disk('public')->delete($president->image_path);
            }

            $data['image_path'] = $request->file('image')->store('presidents', 'public');
        }

        $president->update($data);

        return redirect()
            ->route('presidents.show', $president)
            ->with('success', 'Президент обновлён');
    }

    public function destroy(President $president)
    {
        abort_unless(
            auth()->id() === $president->user_id || auth()->user()->is_admin,
            403
        );

        $president->delete();

        return redirect()->route('presidents.index');
    }

    public function restore($id)
    {
        $president = President::onlyTrashed()->findOrFail($id);

        if (auth()->user()->is_admin || auth()->id() === $president->user_id) {
            $president->restore();
            return back();
        }

        abort(403);
    }

    public function forceDelete($id)
    {
        abort_unless(auth()->user()->is_admin, 403);

        $president = President::withTrashed()->findOrFail($id);

        if ($president->image_path) {
            Storage::disk('public')->delete($president->image_path);
        }

        $president->forceDelete();

        return back();
    }
}
