<?php

use App\Http\Controllers\BusStationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\BusTicketController;

Route::middleware("auth")->group(function () {
   Route::get('/', [ViewController::class, "home"]);
   Route::get("/bus/ticket", [ViewController::class, "busTicket"]);
   Route::get("/bpjs", [ViewController::class, "bpjs"]);
   Route::get("/film", [ViewController::class, "filmTicket"]);
   Route::get("/film/cinema", [ViewController::class, "filmCinema"]);
   Route::get("/film/cinema/seat", [ViewController::class, "cinemaSeat"]);
   Route::get("/game/topup", [ViewController::class, "game"]);
   Route::get("/game/topup/package", [ViewController::class, "gamePackage"]);
   Route::get("/power", [ViewController::class, "power"]);

   Route::get("/master", [ViewController::class, "master"]);
   Route::get("/master/bus/station", [BusStationController::class, "index"]);
   Route::get("/master/bus/station/create", [BusStationController::class, "create"]);
   Route::post("/master/bus/station/create", [BusStationController::class, "store"]);
   Route::get("/master/bus/station/edit/{bus_station}", [BusStationController::class, "edit"]);
   Route::put("/master/bus/station/edit/{bus_station}", [BusStationController::class, "update"]);
   Route::get("/master/bus/station/delete/{bus_station}", [BusStationController::class, "delete"]);
   Route::delete("/master/bus/station/delete/{bus_station}", [BusStationController::class, "destroy"]);
   
   Route::post("/bus-ticket", [BusTicketController::class, "order"]);

   Route::post("/logout", [AuthController::class, "logout"]);
});

Route::middleware("guest")->group(function () {
   Route::get("/login", [AuthController::class, "showLoginForm"])->name("login");
   Route::get("/register", [AuthController::class, "showRegisterForm"])->name("register");

   Route::post("/login", [AuthController::class, "login"]);
   Route::post("/register", [AuthController::class, "register"]);
});