<?php

namespace App\Http\Controllers;

use App\Models\ActiveBpjs;
use Illuminate\Http\Request;
use App\Models\CivilInformation;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ActiveBpjsController extends Controller
{
    public function search(Request $request)
    {
        $validated = $request->validate([
            "civil_id" => "required|exists:civil_informations,NIK"
        ]);

        $civil_information = CivilInformation::where("NIK", "=", $validated["civil_id"])->first();
        $bpjs = ActiveBpjs::with("bpjsClass")->where("civil_information_id", "=", $civil_information->id)->first();

        return redirect("/bpjs")->with("bpjs", $bpjs);
    }
}
