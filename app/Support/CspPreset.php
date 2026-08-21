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
     * Fonts and stylesheets are served from this origin, so neither needs a
     * blanket https: allowance any more.
     *
     * @param Policy $policy
     *
     * @return void
     */
    public function configure(Policy $policy): void
    {
        $policy
            ->add(Directive::IMG, 'data:')
            // Kept from the original policy as a fallback for user agents
            // that do not support nonces. Where nonces are supported this is
            // ignored, since the Basic preset adds one to style-src.
            ->add(Directive::STYLE, Keyword::UNSAFE_INLINE)
            ->add(Directive::FONT, 'data:');
    }
}
