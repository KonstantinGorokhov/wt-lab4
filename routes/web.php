<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresidentController;

Route::get("/", function () {
    return redirect()->route("presidents.index");
});

Route::middleware("auth")->group(function () {
    Route::resource("presidents", PresidentController::class);
});

Route::delete("/presidents/{president}/force", [
    PresidentController::class,
    "forceDelete",
])->name("presidents.forceDelete");

require __DIR__ . "/auth.php";
