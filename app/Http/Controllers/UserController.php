<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
            ->withCount("presidents")
            ->withCount(["deletedPresidents as deleted_presidents_count"]);

        if (auth()->user()?->is_admin && $request->boolean("with_trashed")) {
            $query->withTrashed();
        }

        $users = $query->get();

        return view("users.index", compact("users"));
    }

    public function destroy(User $user)
    {
        abort_unless(auth()->user()->is_admin, 403);

        if ($user->id === auth()->id()) {
            return back()->with("error", "Нельзя удалить самого себя");
        }

        $user->delete();

        return back()->with("success", "Пользователь удалён");
    }

    public function restore($id)
    {
        abort_unless(auth()->user()->is_admin, 403);

        if ((int) $id === auth()->id()) {
            return back()->with("error", "Нельзя восстановить самого себя");
        }

        User::withTrashed()->findOrFail($id)->restore();

        return back()->with("success", "Пользователь восстановлен");
    }

    public function forceDelete($id)
    {
        abort_unless(auth()->user()->is_admin, 403);

        if ((int) $id === auth()->id()) {
            return back()->with("error", "Нельзя удалить самого себя");
        }

        User::withTrashed()->findOrFail($id)->forceDelete();

        return back()->with("success", "Пользователь удалён навсегда");
    }
}
