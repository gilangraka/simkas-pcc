<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        // Google user object dari google
        $userFromGoogle = Socialite::driver('google')->user();

        // Ambil user dari database berdasarkan google mail
        $getEmail = User::where('email', $userFromGoogle->getEmail())->first();

        // Jika tidak ada user, maka buat user baru
        if (!$getEmail) {
            return redirect('/')->with(['error' => 'Email tidak terdaftar']);
        }

        // Jika ada user langsung login saja
        auth('web')->login($getEmail);
        session()->regenerate();
        return redirect('/');
    }
}
