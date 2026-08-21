<?php

namespace App\Http\Controllers;

use App\Http\Requests\Disable2FaRequest;
use App\Http\Requests\Enable2FaRequest;
use App\Models\TwoFAKey;
use App\Models\User;
use App\Support\RecoveryCodes;
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
        /** @var User $user */
        $user = Auth::user();

        $google2fa_url = '';
        $twoFAKey = $user->twoFAKey;

        if ($twoFAKey !== null) {
            $google2fa = app('pragmarx.google2fa');
            $google2fa_url = $google2fa->getQRCodeInline(
                'Cyber Register 2FA',
                $user->email,
                $twoFAKey->google2fa_secret
            );
        }
        $data = [
            'user'                => $user,
            'google2fa_url'       => $google2fa_url,
            'recovery_remaining'  => app(RecoveryCodes::class)->remaining($user),
        ];

        return view('auth.2fa')->with('data', $data);
    }

    /**
     * @return RedirectResponse
     */
    public function generate2faSecret()
    {
        /** @var User $user */
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
     *
     * @return RedirectResponse
     */
    public function enable2fa(Enable2FaRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $twoFAKey = $user->twoFAKey;

        if ($twoFAKey === null) {
            return redirect('/2fa')
                ->with('error', 'Genereer eerst een geheime sleutel.');
        }

        $google2fa = app('pragmarx.google2fa');
        $secret = $request->input('verify-code');
        $valid = $google2fa->verifyKey($twoFAKey->google2fa_secret, $secret);
        if ($valid) {
            $twoFAKey->google2fa_enable = true;
            $twoFAKey->save();

            // Shown once, on the next render, and never retrievable again.
            $codes = app(RecoveryCodes::class)->generate($user);

            return redirect('/2fa')
                ->with('success', '2FA is geactiveerd.')
                ->with('recovery_codes', $codes);
        } else {
            return redirect('/2fa')->with('error', 'OTP code verkeerd, probeer nogmaals.');
        }
    }

    /**
     * Issue a fresh set of recovery codes, discarding the previous one.
     *
     * @return RedirectResponse
     */
    public function regenerateRecoveryCodes(): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->twoFAKey === null || !$user->twoFAKey->google2fa_enable) {
            return redirect('/2fa')
                ->with('error', 'Herstelcodes zijn er pas zodra 2FA is ingeschakeld.');
        }

        $codes = app(RecoveryCodes::class)->generate($user);

        return redirect('/2fa')
            ->with('success', 'Er is een nieuwe set herstelcodes gegenereerd. De vorige set werkt niet meer.')
            ->with('recovery_codes', $codes);
    }

    /**
     * @param Disable2FaRequest $request
     *
     * @return RedirectResponse
     */
    public function disable2fa(Disable2FaRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();
        if (!(Hash::check($request->get('current-password'), $user->password))) {
            // The passwords matches
            return redirect()->back()
                ->with('error', 'Je wachtwoord klopt niet, probeer nogmaals.');
        }

        $twoFAKey = $user->twoFAKey;

        if ($twoFAKey === null) {
            return redirect('/2fa')->with('error', '2FA staat niet ingesteld.');
        }

        $twoFAKey->google2fa_enable = false;
        $twoFAKey->save();

        return redirect('/2fa')->with('success', '2FA is uitgeschakeld.');
    }
}
