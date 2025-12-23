<?php

namespace App\Http\Controllers;

use App\Models\President;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;

class PresidentController extends Controller
{
    public function index(Request $request)
    {
        $selectedUser = null;

        $query = President::query()->with("user");

        // фильтр по пользователю
        if ($request->filled("username")) {
            $selectedUser = User::where(
                "username",
                $request->username,
            )->firstOrFail();
            $query->where("user_id", $selectedUser->id);
        }

        // чекбокс "показать удалённые"
        if (auth()->check() && $request->boolean("with_trashed")) {
            // админ — может смотреть любые удалённые
            if (auth()->user()->is_admin) {
                $query->withTrashed();
            }

            // обычный пользователь — ТОЛЬКО свои
            elseif ($selectedUser && auth()->id() === $selectedUser->id) {
                $query->withTrashed();
            }
        }

        $presidents = $query->latest()->get();

        return view("presidents.index", compact("presidents", "selectedUser"));
    }

    public function create()
    {
        return view("presidents.create");
    }

    public function show(President $president)
    {
        return view("presidents.show", compact("president"));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "name_ru" => "required",
            "name_en" => "required",
            "period" => "required",
            "short_description" => "required",
            "full_description" => "nullable",
            "term_start" => "nullable|date",
            "term_end" => "nullable|date",
            "image" => "nullable|image",
        ]);

        $data["slug"] = Str::slug($data["name_en"]);
        $data["user_id"] = auth()->id();
        President::create($data);

        if ($request->hasFile("image")) {
            $data["image_path"] = $request
                ->file("image")
                ->store("presidents", "public");
        }

        President::create($data);

        return redirect()->route("presidents.index");
    }

    public function edit(President $president)
    {
        abort_unless(
            Auth::id() === $president->user_id || Auth::user()->is_admin,
            403,
        );

        return view("presidents.edit", compact("president"));
    }

    public function update(Request $request, President $president)
    {
        abort_unless(
            Auth::id() === $president->user_id || Auth::user()->is_admin,
            403,
        );

        $data = $request->validate([
            "name_ru" => "required",
            "name_en" => "required",
            "period" => "required",
            "short_description" => "required",
            "full_description" => "nullable",
        ]);

        $president->update($data);

        return redirect()->route("presidents.show", $president);
    }

    public function destroy(President $president)
    {
        abort_unless(
            Auth::id() === $president->user_id || Auth::user()->is_admin,
            403,
        );

        $president->delete();

        return redirect()->route("presidents.index");
    }

    public function restore($id)
    {
        $president = President::onlyTrashed()->findOrFail($id);

        // админ
        if (auth()->user()->is_admin) {
            $president->restore();
            return back();
        }

        // владелец карточки
        if ($president->user_id === auth()->id()) {
            $president->restore();
            return back();
        }

        abort(403);
    }

    public function forceDelete($id)
    {
        abort_unless(Auth::user()->is_admin, 403);

        $president = President::withTrashed()->findOrFail($id);

        if ($president->image_path) {
            Storage::disk("public")->delete($president->image_path);
        }

        $president->forceDelete();

        return back();
    }
}
