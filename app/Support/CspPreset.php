<?php

namespace App\Support;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

/**
 * Application specific additions on top of the Basic preset.
 */
class CspPreset implements Preset
{
    /**
     * Add the application's own directives to the policy.
     *
     * @param Policy $policy
     *
     * @return void
     */
    public function configure(Policy $policy): void
    {
        $policy
            ->add(Directive::IMG, 'data:')
            ->add(Directive::STYLE, ['https:', Keyword::UNSAFE_INLINE])
            ->add(Directive::FONT, [Keyword::SELF, 'data:', 'https:']);
    }
}
