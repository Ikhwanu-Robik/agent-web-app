<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view("login");
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
        return view("register");
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            "password" => "required"
        ]);

        User::create($validated);

        return redirect("/");
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect("/login");
    }
}
