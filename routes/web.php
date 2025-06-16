<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {
   Route::get('/', function () {
      return view('home');
   });

   Route::post("/logout", [AuthController::class, "logout"]);
});

Route::middleware("guest")->group(function () {
   Route::get("/login", [AuthController::class, "showLoginForm"])->name("login");
   Route::get("/register", [AuthController::class, "showRegisterForm"])->name("register");

   Route::post("/login", [AuthController::class, "login"]);
   Route::post("/register", [AuthController::class, "register"]);
});
