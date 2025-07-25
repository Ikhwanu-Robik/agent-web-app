<?php

namespace App\Http\Controllers\utilities;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $validated = $request->validate([
            "email" => "required|email|exists:users,email",
            "password" => "required"
        ]);

        if (Auth::attempt($validated)) {
            return redirect("/");
        }

        return redirect()->back()->with("auth_fail", "email or password is wrong");
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "profile_photo" => [
                "required",
                "image",
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!$value->isValid()) {
                        $fail("Photo profile is not uploaded successfully");
                    }
                }
            ],
            "email" => "required|email|unique:users,email",
            "password" => "required"
        ]);
        $validated = $validator->validated();

        $file_name = $request->file("profile_photo")->storePublicly();
        $validated["profile_photo"] = $file_name;

        User::create($validated);

        return redirect("/");
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect("/login");
    }
}
