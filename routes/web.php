<?php

use App\Http\Controllers\FlipCallbackController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\businesses\AuthController;
use App\Http\Controllers\views\GeneralViewController;

require("pages.php");
require("admin.php");
require("bus_ticket.php");
require("bpjs.php");
require("film_ticket.php");
require("game_topup.php");
require("power_topup.php");

Route::middleware("auth")->group(function () {
   Route::post("/logout", [AuthController::class, "logout"]);
});

Route::middleware("guest")->group(function () {
   Route::get("/login", [GeneralViewController::class, "showLoginForm"])->name("login");
   Route::post("/login", [AuthController::class, "login"]);

   Route::get("/register", [GeneralViewController::class, "showRegisterForm"])->name("register");
   Route::post("/register", [AuthController::class, "register"]);
});

Route::post("/flipcallback", FlipCallbackController::class);
