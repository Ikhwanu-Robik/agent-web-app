<?php

use App\Http\Controllers\views\GeneralViewController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {
    Route::get('/', [GeneralViewController::class, "home"])->name("home");
    Route::get("/report", [GeneralViewController::class, "report"])->name("report");
    Route::get("/vouchers", [GeneralViewController::class, "vouchers"])->name("vouchers");
});