<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\views\ViewController;
use App\Http\Controllers\resources\BusController;
use App\Http\Controllers\resources\FilmController;
use App\Http\Controllers\resources\CinemaController;
use App\Http\Controllers\resources\VoucherController;
use App\Http\Controllers\resources\BpjsPriceController;
use App\Http\Controllers\resources\BusStationController;
use App\Http\Controllers\resources\CinemaFilmController;
use App\Http\Controllers\resources\BusScheduleController;

Route::middleware("auth")->group(function () {
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

      Route::prefix("/bpjs/prices")->group(function () {
         Route::get("/", [BpjsPriceController::class, "index"]);
         Route::get("/create", [BpjsPriceController::class, "create"]);
         Route::post("/create", [BpjsPriceController::class, "store"]);
         Route::get("/edit/{bpjs_price}", [BpjsPriceController::class, "edit"]);
         Route::put("/edit/{bpjs_price}", [BpjsPriceController::class, "update"]);
         Route::get("/delete/{bpjs_price}", [BpjsPriceController::class, "delete"]);
         Route::delete("/delete/{bpjs_price}", [BpjsPriceController::class, "destroy"]);
      });

      Route::prefix("/cinemas")->group(function () {
         Route::get("/", [CinemaController::class, "index"]);
         Route::get("/create", [CinemaController::class, "create"]);
         Route::post("/create", [CinemaController::class, "store"]);
         Route::get("/edit/{cinema}", [CinemaController::class, "edit"]);
         Route::put("/edit/{cinema}", [CinemaController::class, "update"]);
         Route::get("/delete/{cinema}", [CinemaController::class, "delete"]);
         Route::delete("/delete/{cinema}", [CinemaController::class, "destroy"]);

         Route::get("/{cinema}/films", [CinemaFilmController::class, "index"]);
         Route::get("/{cinema}/films/schedule", [CinemaFilmController::class, "create"]);
         Route::post("/{cinema}/films/schedule", [CinemaFilmController::class, "store"]);
         Route::delete("/{cinema}/films/schedule/{cinema_film}", [CinemaFilmController::class, "destroy"]);
      });

      Route::prefix("/films")->group(function () {
         Route::get("/", [FilmController::class, "index"]);
         Route::get("/create", [FilmController::class, "create"]);
         Route::post("/create", [FilmController::class, "store"]);
         Route::get("/edit/{film}", [FilmController::class, "edit"]);
         Route::put("/edit/{film}", [FilmController::class, "update"]);
         Route::get("/delete/{film}", [FilmController::class, "delete"]);
         Route::delete("/delete/{film}", [FilmController::class, "destroy"]);
      });
   });
});