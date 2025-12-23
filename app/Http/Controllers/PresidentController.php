<?php

namespace App\Http\Controllers;

use App\Models\President;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PresidentController extends Controller
{
    public function index(Request $request)
    {
        $sort = 'term_start';
        $dir  = $request->get('direction', 'asc');

        $presidents = President::orderBy($sort, $dir)->get();

        return view('presidents.index', compact('presidents', 'dir'));
    }

    public function create()
    {
        return view('presidents.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_ru'           => 'required|string|max:255',
            'name_en'           => 'required|string|max:255',
            'period'            => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'full_description'  => 'nullable|string',
            'term_start'        => 'nullable|date',
            'term_end'          => 'nullable|date|after_or_equal:term_start',
            'image'             => 'nullable|image|max:2048'
        ]);

        $data['slug'] = Str::slug($data['name_en']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('presidents', 'public');
        }

        President::create($data);

        return redirect()->route('presidents.index')
            ->with('success', 'Президент добавлен.');
    }

    public function show(President $president)
    {
        return view('presidents.show', compact('president'));
    }

    public function edit(President $president)
    {
        return view('presidents.edit', compact('president'));
    }

    public function update(Request $request, President $president)
    {
        $data = $request->validate([
            'name_ru'           => 'required|string|max:255',
            'name_en'           => 'required|string|max:255',
            'period'            => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'full_description'  => 'nullable|string',
            'term_start'        => 'nullable|date',
            'term_end'          => 'nullable|date|after_or_equal:term_start',
            'image'             => 'nullable|image|max:2048'
        ]);

        $data['slug'] = Str::slug($data['name_en']);

        if ($request->hasFile('image')) {
            if ($president->image_path) {
                Storage::disk('public')->delete($president->image_path);
            }
            $data['image_path'] = $request->file('image')->store('presidents', 'public');
        }

        $president->update($data);

        return redirect()->route('presidents.index')
            ->with('success', 'Данные обновлены.');
    }

    public function destroy(President $president)
    {
        $president->delete();

        return redirect()->route('presidents.index')
            ->with('success', 'Президент удалён.');
    }
}
