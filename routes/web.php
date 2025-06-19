<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\BusTicketController;

Route::middleware("auth")->group(function () {
   Route::get('/', [ViewController::class, "home"]);
   Route::get("/bus-ticket", [ViewController::class, "busTicket"]);
   Route::get("/bpjs", [ViewController::class, "bpjs"]);

   Route::post("/bus-ticket", [BusTicketController::class, "order"]);

   Route::post("/logout", [AuthController::class, "logout"]);
});

Route::middleware("guest")->group(function () {
   Route::get("/login", [AuthController::class, "showLoginForm"])->name("login");
   Route::get("/register", [AuthController::class, "showRegisterForm"])->name("register");

   Route::post("/login", [AuthController::class, "login"]);
   Route::post("/register", [AuthController::class, "register"]);
});