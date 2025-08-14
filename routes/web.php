<?php

use App\Http\Controllers\FlipCallbackController;
use Illuminate\Support\Facades\Route;

require("auth.php");
require("general.php");
require("admin.php");
require("bus_ticket.php");
require("bpjs.php");
require("film_ticket.php");
require("game_top_up.php");
require("power_top_up.php");

Route::post("/flipcallback", FlipCallbackController::class)->name("flipcallback");
