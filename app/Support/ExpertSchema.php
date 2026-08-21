<?php

namespace App\Support;

use App\Models\User;

/**
 * Builds schema.org structured data so the register can be read by machines.
 */
class ExpertSchema
{
    /**
     * Describe an expert as a schema.org Person.
     *
     * Only unexpired registrations are described. A lapsed registration is
     * not a credential the register is willing to vouch for, and listing it
     * would contradict what the page itself says.
     *
     * @param User $user
     *
     * @return array<string, mixed>
     */
    public static function forExpert(User $user): array
    {
        $schema = [
            '@context'   => 'https://schema.org',
            '@type'      => 'Person',
            'name'       => $user->name,
            'identifier' => $user->cyber_code,
            'url'        => route('expert.show', ['user' => $user->cyber_code]),
        ];

        if (!empty($user->photo)) {
            $schema['image'] = $user->photo;
        }

        $credentials = [];

        foreach ($user->expertises as $expertise) {
            if (!$expertise->isValid) {
                continue;
            }

            $credential = [
                '@type'                 => 'EducationalOccupationalCredential',
                'credentialCategory'    => 'certification',
                'name'                  => $expertise->code,
                'recognizedBy'          => [
                    '@type' => 'Organization',
                    'name'  => config('app.name'),
                ],
            ];

            if ($expertise->description !== null) {
                $credential['description'] = $expertise->description;
            }

            if ($expertise->date_of_expiration !== null) {
                $credential['expires'] = $expertise->date_of_expiration->toDateString();
            }

            if ($expertise->date_of_certification !== null) {
                $credential['dateCreated'] = $expertise->date_of_certification->toDateString();
            }

            $credentials[] = $credential;
        }

        if ($credentials !== []) {
            $schema['hasCredential'] = $credentials;
        }

        return $schema;
    }
}
