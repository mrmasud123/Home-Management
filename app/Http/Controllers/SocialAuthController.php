<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $member = Member::where('email', $request->email)->first();

        if (! $member) {
            return response()->json([
                'success' => false,
                'message' => 'No account found with this email.',
            ], 404);
        }

        Auth::login($member, remember: true);
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Logged in successfully.',
            'redirect' => route('meal.home'),
        ], 200);
    }
    public function redirect(Request $request)
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        $googleUser = Socialite::driver('google')->user();
        $member = Member::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'joined_date' => Carbon::parse(date("Y-m-d"))->startOfMonth()->format('Y-m-d'),
                'status' =>1,
                'seat_rent' =>0
            ]
        );
        Auth::login($member, remember: true);
        request()->session()->regenerate();
        return redirect()->route('meal.home');
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('web')->user();

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
