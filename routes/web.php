<?php

use App\Http\Controllers\views\ViewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\utilities\AuthController;

require("pages.php");
require("admin.php");
require("bus_ticket.php");
require("bpjs.php");
require("film_ticket.php");

Route::middleware("auth")->group(function () {
   Route::post("/logout", [AuthController::class, "logout"]);
});

Route::middleware("guest")->group(function () {
   Route::get("/login", [ViewController::class, "showLoginForm"])->name("login");
   Route::post("/login", [AuthController::class, "login"]);

   Route::get("/register", [ViewController::class, "showRegisterForm"])->name("register");
   Route::post("/register", [AuthController::class, "register"]);
});
