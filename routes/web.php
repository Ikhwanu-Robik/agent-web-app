<?php

use App\Http\Controllers\BusController;
use App\Http\Controllers\BusScheduleController;
use App\Http\Controllers\BusStationController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\BusTicketController;

Route::middleware("auth")->group(function () {
   Route::get('/', [ViewController::class, "home"]);
   Route::get("/report", [ViewController::class, "report"]);
   Route::get("/vouchers", [ViewController::class, "vouchers"]);
   Route::get("/bus/ticket", [ViewController::class, "busTicket"]);
   Route::get("/bpjs", [ViewController::class, "bpjs"]);
   Route::get("/film", [ViewController::class, "filmTicket"]);
   Route::get("/film/cinema", [ViewController::class, "filmCinema"]);
   Route::get("/film/cinema/seat", [ViewController::class, "cinemaSeat"]);
   Route::get("/game/topup", [ViewController::class, "game"]);
   Route::get("/game/topup/package", [ViewController::class, "gamePackage"]);
   Route::get("/power", [ViewController::class, "power"]);

   Route::get("/master", [ViewController::class, "master"]);

   Route::prefix("/master")->group(function () {

      Route::prefix("/vouchers")->group(function () {
         Route::get("/", [VoucherController::class, "index"]);
         Route::get("/create", [VoucherController::class, "create"]);
         Route::post("/create", [VoucherController::class, "store"]);
         Route::get("/edit/{voucher}", [VoucherController::class, "edit"]);
         Route::put("/edit/{voucher}", [VoucherController::class, "update"]);
         Route::get("/delete/{voucher}", [VoucherController::class, "delete"]);
         Route::delete("/delete/{voucher}", [VoucherController::class, "destroy"]);
      });

      Route::prefix("/bus/station")->group(function () {
         Route::get("/", [BusStationController::class, "index"]);
         Route::get("/create", [BusStationController::class, "create"]);
         Route::post("/create", [BusStationController::class, "store"]);
         Route::get("/edit/{bus_station}", [BusStationController::class, "edit"]);
         Route::put("/edit/{bus_station}", [BusStationController::class, "update"]);
         Route::get("/delete/{bus_station}", [BusStationController::class, "delete"]);
         Route::delete("/delete/{bus_station}", [BusStationController::class, "destroy"]);
      });

      Route::prefix("/bus")->group(function () {
         Route::get("/", [BusController::class, "index"]);
         Route::get("/create", [BusController::class, "create"]);
         Route::post("/create", [BusController::class, "store"]);
         Route::get("/edit/{bus}", [BusController::class, "edit"]);
         Route::put("/edit/{bus}", [BusController::class, "update"]);
         Route::get("/delete/{bus}", [BusController::class, "delete"]);
         Route::delete("/delete/{bus}", action: [BusController::class, "destroy"]);
      });

      Route::prefix("/bus/schedules")->group(function () {
         Route::get("/", [BusScheduleController::class, "index"]);
         Route::get("/create", [BusScheduleController::class, "create"]);
         Route::post("/create", [BusScheduleController::class, "store"]);
         Route::get("/edit/{schedule}", action: [BusScheduleController::class, "edit"]);
         Route::put("/edit/{schedule}", [BusScheduleController::class, "update"]);
         Route::get("/delete/{schedule}", [BusScheduleController::class, "delete"]);
         Route::delete("/delete/{schedule}", action: [BusScheduleController::class, "destroy"]);
      });

   });

   Route::post("/bus/schedules", [BusScheduleController::class, "search"]);
   Route::post("/bus/ticket", [BusTicketController::class, "order"]);
   Route::get("/bus/ticket/payment", [BusTicketController::class, "payment"]);
   Route::post("/bus/ticket/pay", [BusTicketController::class, "pay"]);
   Route::get("/bus/ticket/finished", [BusTicketController::class, "receipt"]);

   Route::post("/logout", [AuthController::class, "logout"]);
});

Route::middleware("guest")->group(function () {
   Route::get("/login", [AuthController::class, "showLoginForm"])->name("login");
   Route::get("/register", [AuthController::class, "showRegisterForm"])->name("register");

   Route::post("/login", [AuthController::class, "login"]);
   Route::post("/register", [AuthController::class, "register"]);
});
