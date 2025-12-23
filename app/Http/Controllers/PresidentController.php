<?php

namespace App\Http\Controllers;

use App\Models\President;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PresidentController extends Controller
{
    /**
     * Список президентов (по умолчанию — активные)
     * Администратор может смотреть вместе с удалёнными
     */
    public function index(Request $request)
    {
        $sort = "term_start";
        $dir = $request->get("direction", "asc");

        $query = President::orderBy($sort, $dir);

        if (auth()->user()->is_admin && $request->get("with_trashed")) {
            $query->withTrashed();
        }

        $presidents = $query->get();

        return view("presidents.index", compact("presidents", "dir"));
    }

    /**
     * Президенты конкретного пользователя (по username)
     */
    public function byUser(User $user)
    {
        $query = $user->presidents()->orderBy("term_start");

        if (auth()->user()->is_admin) {
            $query->withTrashed();
        }

        $presidents = $query->get();

        return view("presidents.index", compact("presidents", "user"));
    }

    /**
     * Форма создания
     */
    public function create()
    {
        return view("presidents.create");
    }

    /**
     * Сохранение нового президента
     * Создавать может любой авторизованный пользователь
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "name_ru" => "required|string|max:255",
            "name_en" => "required|string|max:255",
            "period" => "required|string|max:255",
            "short_description" => "required|string|max:500",
            "full_description" => "nullable|string",
            "term_start" => "nullable|date",
            "term_end" => "nullable|date|after_or_equal:term_start",
            "image" => "nullable|image|max:2048",
        ]);

        $data["slug"] = Str::slug($data["name_en"]);
        $data["user_id"] = auth()->id();

        if ($request->hasFile("image")) {
            $data["image_path"] = $request
                ->file("image")
                ->store("presidents", "public");
        }

        President::create($data);

        return redirect()
            ->route("presidents.index")
            ->with("success", "Президент добавлен.");
    }

    /**
     * Просмотр одного президента
     */
    public function show(President $president)
    {
        return view("presidents.show", compact("president"));
    }

    /**
     * Форма редактирования
     * Только владелец или администратор
     */
    public function edit(President $president)
    {
        Gate::authorize("update-president", $president);

        return view("presidents.edit", compact("president"));
    }

    /**
     * Обновление
     * Только владелец или администратор
     */
    public function update(Request $request, President $president)
    {
        Gate::authorize("update-president", $president);

        $data = $request->validate([
            "name_ru" => "required|string|max:255",
            "name_en" => "required|string|max:255",
            "period" => "required|string|max:255",
            "short_description" => "required|string|max:500",
            "full_description" => "nullable|string",
            "term_start" => "nullable|date",
            "term_end" => "nullable|date|after_or_equal:term_start",
            "image" => "nullable|image|max:2048",
        ]);

        $data["slug"] = Str::slug($data["name_en"]);

        if ($request->hasFile("image")) {
            if ($president->image_path) {
                Storage::disk("public")->delete($president->image_path);
            }
            $data["image_path"] = $request
                ->file("image")
                ->store("presidents", "public");
        }

        $president->update($data);

        return redirect()
            ->route("presidents.index")
            ->with("success", "Данные обновлены.");
    }

    /**
     * Мягкое удаление
     * Только владелец или администратор
     */
    public function destroy(President $president)
    {
        Gate::authorize("delete-president", $president);

        $president->delete();

        return redirect()->back()->with("success", "Президент удалён.");
    }

    /**
     * Восстановление (ТОЛЬКО администратор)
     */
    public function restore($id)
    {
        Gate::authorize("restore-president");

        $president = President::withTrashed()->findOrFail($id);
        $president->restore();

        return redirect()->back()->with("success", "Президент восстановлен.");
    }

    /**
     * Полное удаление (ТОЛЬКО администратор)
     */
    public function forceDelete($id)
    {
        Gate::authorize("restore-president");

        $president = President::withTrashed()->findOrFail($id);

        if ($president->image_path) {
            Storage::disk("public")->delete($president->image_path);
        }

        $president->forceDelete();

        return redirect()
            ->back()
            ->with("success", "Президент удалён безвозвратно.");
    }
}
