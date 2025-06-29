<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view("auth.login");
    }

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

    public function showRegisterForm()
    {
        return view("auth.register");
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string",
            "profile_photo" => "required|image",
            "email" => "required|email|unique:users,email",
            "password" => "required"
        ]);

        if (!$request->file("profile_photo")->isValid()) {
            return response("Photo profil is not uploaded successfully", 422);
        }
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
