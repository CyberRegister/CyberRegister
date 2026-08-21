<?php

return [

    /*
     * Presets will determine which CSP headers will be set. A valid CSP preset is
     * any class that implements `Spatie\Csp\Preset`.
     */
    'presets' => [
        \Spatie\Csp\Presets\Basic::class,
        \App\Support\CspPreset::class,
    ],

    /*
     * These presets which will be put in report only mode. This is great for testing out
     * a new policy or changes to existing csp policy without breaking anything.
     */
    'report_only_presets' => [],

    /*
     * These directives will be added to the policies.
     */
    'directives' => [],

    /*
     * These directives will be added to the report only policies.
     */
    'report_only_directives' => [],

    /*
     * All violations against the policy will be reported to this url.
     * A great service you could use for this is https://report-uri.com/
     *
     * You can override this setting by calling `reportTo` on your policy.
     */
    'report_uri' => env('CSP_REPORT_URI', env('SENTRY_CSP', '')),

    /*
     * Headers will only be added if this setting is set to true.
     */
    'enabled' => env('CSP_ENABLED', true),

    /*
     * The class responsible for generating the nonces used in inline tags and headers.
     */
    'nonce_generator' => Spatie\Csp\Nonce\RandomString::class,

    /*
     * Set to false to stop adding nonces to the policy. The WebAuthn views
     * rely on nonces for their inline scripts.
     */
    'nonce_enabled' => env('CSP_NONCE_ENABLED', true),

    /*
     * Set to true to add the CSP headers while hot reloading assets.
     */
    'enabled_while_hot_reloading' => env('CSP_ENABLED_WHILE_HOT_RELOADING', false),
];
