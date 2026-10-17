<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $g = Socialite::driver('google')->user();

        // Find by google_id or email; create a normal user if none exists
        $user = User::where('google_id', $g->getId())->orWhere('email', $g->getEmail())->first();

        if (! $user) {
            $user = User::create([
                'username' => $g->getName(),
                'email' => $g->getEmail(),
                'google_id' => $g->getId(),
                'role' => 'user',
                'email_verified_at' => now(),
            ]);
        } elseif (! $user->google_id) {
            $user->update(['google_id' => $g->getId()]);
        }

        Auth::login($user);
        return redirect('/dashboard');
    }
}
