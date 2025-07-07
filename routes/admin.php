<?php

use App\Http\Controllers\BpjsPriceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\BusStationController;
use App\Http\Controllers\BusScheduleController;

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
         // Route::get("/create", [BpjsPriceController::class, "create"]);
         // Route::post("/create", [BpjsPriceController::class, "store"]);
         // Route::get("/edit/{schedule}", action: [BpjsPriceController::class, "edit"]);
         // Route::put("/edit/{schedule}", [BpjsPriceController::class, "update"]);
         // Route::get("/delete/{schedule}", [BpjsPriceController::class, "delete"]);
         // Route::delete("/delete/{schedule}", action: [BpjsPriceController::class, "destroy"]);
      });
   });
});