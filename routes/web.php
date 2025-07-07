<?php

use App\Http\Controllers\BusController;
use App\Http\Controllers\BusScheduleController;
use App\Http\Controllers\BusStationController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\BusTicketController;

require("pages.php");
require("admin.php");
require("bus_ticket.php");
require("bpjs.php");

Route::middleware("auth")->group(function () {
   Route::post("/logout", [AuthController::class, "logout"]);
});

Route::middleware("guest")->group(function () {
   Route::get("/login", [AuthController::class, "showLoginForm"])->name("login");
   Route::get("/register", [AuthController::class, "showRegisterForm"])->name("register");

   Route::post("/login", [AuthController::class, "login"]);
   Route::post("/register", [AuthController::class, "register"]);
});
