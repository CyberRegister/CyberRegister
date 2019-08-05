<?php

namespace App\Http\Controllers;

use App\Http\Requests\Disable2FaRequest;
use App\Http\Requests\Enable2FaRequest;
use App\TwoFAKey;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class TwoFAController extends Controller
{
    /**
     * @return View
     */
    public function show2faForm()
    {
        $user = Auth::user();

        $google2fa_url = '';

        if ($user->twoFAKey()->exists()) {
            $google2fa = app('pragmarx.google2fa');
            $google2fa_url = $google2fa->getQRCodeInline(
                'Cyber Register 2FA',
                $user->email,
                $user->twoFAKey->google2fa_secret
            );
        }
        $data = [
            'user'          => $user,
            'google2fa_url' => $google2fa_url,
        ];

        return view('auth.2fa')->with('data', $data);
    }

    /**
     * @return RedirectResponse
     */
    public function generate2faSecret()
    {
        $user = Auth::user();
        // Initialise the 2FA class
        $google2fa = app('pragmarx.google2fa');

        // Add the secret key to the registration data
        TwoFAKey::create(
            [
            'user_id'          => $user->id,
            'google2fa_enable' => 0,
            'google2fa_secret' => $google2fa->generateSecretKey(),
            ]
        );

        return redirect('/2fa')->with('success', 'Geheime sleutel is gegenereerd, voer OTP in om 2FA te activeren.');
    }

    /**
     * @param Enable2FaRequest $request
     * @return RedirectResponse
     */
    public function enable2fa(Enable2FaRequest $request)
    {
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        $secret = $request->input('verify-code');
        $valid = $google2fa->verifyKey($user->twoFAKey->google2fa_secret, $secret);
        if ($valid) {
            $user->twoFAKey->google2fa_enable = true;
            $user->twoFAKey->save();

            return redirect('/2fa')->with('success', '2FA is geactiveerd.');
        } else {
            return redirect('/2fa')->with('error', 'OTP code verkeerd, probeer nogmaals.');
        }
    }

    /**
     * @param Disable2FaRequest $request
     * @return RedirectResponse
     */
    public function disable2fa(Disable2FaRequest $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()
                ->with('error', 'Je wachtwoord klopt niet, probeer nogmaals.');
        }
        $user = Auth::user();
        $user->twoFAKey->google2fa_enable = false;
        $user->twoFAKey->save();

        return redirect('/2fa')->with('success', '2FA is uitgeschakeld.');
    }
}
