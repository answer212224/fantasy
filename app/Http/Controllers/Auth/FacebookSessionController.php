<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Laravel\Socialite\Facades\Socialite;

class FacebookSessionController extends Controller
{
    public function index()
    {
        $user = Socialite::driver('facebook')->user();
        $member = Member::updateOrCreate(
            [
                'fb' => $user->id
            ],
            [
                'ip' => getIp(),
                'name' => $user->name,
                'email' => $user->email
            ]
        );
        session(['member_id' => $member->id]);

        return redirect(env('APP_URL') . '/member');
    }

    public function destroy(Request $request)
    {
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/fantasy');
    }
}
