<?php

namespace App\Support;

use App\Models\RecoveryCode;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Recovery\Recovery;

/**
 * Issues and redeems two factor recovery codes.
 */
class RecoveryCodes
{
    /**
     * How many codes a user gets.
     *
     * @var int
     */
    public const COUNT = 8;

    /**
     * Replace a user's recovery codes with a fresh set.
     *
     * Any codes still outstanding are discarded, so issuing a new set
     * invalidates whatever was written down before.
     *
     * @param User $user
     *
     * @return list<string> the plain codes, which cannot be read back later
     */
    public function generate(User $user): array
    {
        $codes = (new Recovery())
            ->setCount(self::COUNT)
            ->setBlocks(3)
            ->setChars(5)
            ->uppercase()
            ->toArray();

        RecoveryCode::where('user_id', $user->id)->delete();

        foreach ($codes as $code) {
            RecoveryCode::create(
                [
                    'user_id' => $user->id,
                    'code'    => Hash::make($code),
                ]
            );
        }

        return array_values($codes);
    }

    /**
     * Spend a recovery code, if it is one of this user's unused codes.
     *
     * Codes are hashed, so each candidate has to be checked in turn. There
     * are only ever a handful.
     *
     * @param User   $user
     * @param string $code
     *
     * @return bool
     */
    public function consume(User $user, string $code): bool
    {
        $candidate = $this->normalise($code);

        foreach (RecoveryCode::where('user_id', $user->id)->unused()->get() as $stored) {
            if (Hash::check($candidate, $stored->code)) {
                $stored->used_at = Carbon::now();
                $stored->save();

                return true;
            }
        }

        return false;
    }

    /**
     * How many codes the user has left.
     *
     * @param User $user
     *
     * @return int
     */
    public function remaining(User $user): int
    {
        return RecoveryCode::where('user_id', $user->id)->unused()->count();
    }

    /**
     * Accept a code however it was typed.
     *
     * @param string $code
     *
     * @return string
     */
    private function normalise(string $code): string
    {
        return strtoupper(trim($code));
    }
}
