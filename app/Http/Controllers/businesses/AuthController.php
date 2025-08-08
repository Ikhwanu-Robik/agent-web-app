<?php

namespace App\Http\Controllers\businesses;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $loginRequest)
    {
        $validated = $loginRequest->validated();

        if (Auth::attempt($validated)) {
            return redirect()->route("home");
        }

        return redirect()->back()->with("auth_fail", "email or password is wrong");
    }

    public function register(RegisterRequest $registerRequest)
    {
        $validated = $registerRequest->validated();

        $fileName = $registerRequest->file("profile_photo")->storePublicly();
        $validated["profile_photo"] = $fileName;

        User::create($validated);

        return redirect()->route("home");
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect()->route("login");
    }
}
