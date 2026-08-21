<?php

namespace App\Support;

use PragmaRX\Google2FALaravel\Events\LoginFailed;
use PragmaRX\Google2FALaravel\Events\LoginSucceeded;
use PragmaRX\Google2FALaravel\Exceptions\InvalidSecretKey;
use PragmaRX\Google2FALaravel\Support\Authenticator;
use PragmaRX\Google2FALaravel\Support\Constants;

class Google2FAAuthenticator extends Authenticator
{
    /**
     * @return bool
     */
    protected function canPassWithoutCheckingOTP(): bool
    {
        if (is_null($this->getUser()->twoFAKey)) {
            return true;
        }

        return
            !$this->getUser()->twoFAKey->google2fa_enable ||
            !$this->isEnabled() ||
            $this->noUserIsAuthenticated() ||
            $this->twoFactorAuthStillValid();
    }

    /**
     * Accept a recovery code where a one time password is expected.
     *
     * The same field takes either. A one time password is six digits, so
     * anything else can only be a recovery code, and handing that to the
     * verifier would fail on the format rather than on the value.
     *
     * @return string one of the Constants::OTP_* values
     */
    protected function checkOTP()
    {
        if (!$this->inputHasOneTimePassword() || empty($this->getInputOneTimePassword())) {
            return Constants::OTP_EMPTY;
        }

        $input = (string) $this->getInputOneTimePassword();

        if (ctype_digit($input)) {
            return parent::checkOTP();
        }

        if (app(RecoveryCodes::class)->consume($this->getUser(), $input)) {
            $this->login();
            // The parent fires these through a private helper, so a subclass
            // has to raise them itself to keep listeners working.
            event(new LoginSucceeded($this->getUser()));

            return Constants::OTP_VALID;
        }

        event(new LoginFailed($this->getUser()));

        return Constants::OTP_INVALID;
    }

    /**
     * @throws InvalidSecretKey
     *
     * @return string
     */
    protected function getGoogle2FASecretKey(): string
    {
        $secret = $this->getUser()->twoFAKey->{$this->config('otp_secret_column')};

        if (is_null($secret) || empty($secret)) {
            throw new InvalidSecretKey('Secret key cannot be empty.');
        }

        return $secret;
    }
}
