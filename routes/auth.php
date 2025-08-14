<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\businesses\AuthController;
use App\Http\Controllers\views\GeneralViewController;

Route::middleware("auth")->group(function () {
   Route::post("/logout", [AuthController::class, "logout"])->name("logout");
});

Route::middleware("guest")->group(function () {
   Route::get("/login", [GeneralViewController::class, "showLoginForm"])->name("login.form");
   Route::post("/login", [AuthController::class, "login"])->name("login");

   Route::get("/register", [GeneralViewController::class, "showRegisterForm"])->name("register.form");
   Route::post("/register", [AuthController::class, "register"])->name("register");
});