<?php

namespace App\Support;

use PragmaRX\Google2FALaravel\Exceptions\InvalidSecretKey;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class Google2FAAuthenticator extends Authenticator
{
    /**
     * @return bool
     */
    protected function canPassWithoutCheckingOTP(): bool
    {
        if(is_null($this->getUser()->twoFAKey)) {
            return true;
        }
        return
            !$this->getUser()->twoFAKey->google2fa_enable ||
            !$this->isEnabled() ||
            $this->noUserIsAuthenticated() ||
            $this->twoFactorAuthStillValid();
    }

    /**
     * @return string
     * @throws InvalidSecretKey
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