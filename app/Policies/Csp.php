<?php

namespace App\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;

class Csp extends Basic
{
    /**
     * @throws \Spatie\Csp\Exceptions\InvalidDirective
     */
    public function configure()
    {
        parent::configure();
        $this
            ->addDirective(Directive::IMG, 'data:')
            ->addDirective(Directive::STYLE, 'https:')
            ->addDirective(Directive::FONT, 'self')
            ->addDirective(Directive::FONT, 'https:');
    }
}
