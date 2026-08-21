<?php

namespace Tests\Feature;

use App\Models\Expertise;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StructuredDataTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    /**
     * The expert page carries a machine readable description of the person.
     */
    public function testExpertPageEmitsPersonSchema()
    {
        $user = User::factory()->create();
        Expertise::factory()->create(['user_id' => $user->id]);

        $schema = $this->schemaFor($user);

        $this->assertSame('https://schema.org', $schema['@context']);
        $this->assertSame('Person', $schema['@type']);
        $this->assertSame($user->name, $schema['name']);
        $this->assertSame($user->cyber_code, $schema['identifier']);
        $this->assertSame(route('expert.show', ['user' => $user->cyber_code]), $schema['url']);
    }

    /**
     * A valid registration is described as a credential.
     */
    public function testValidRegistrationIsDescribedAsCredential()
    {
        $user = User::factory()->create();
        $expertise = Expertise::factory()->create(['user_id' => $user->id]);

        $schema = $this->schemaFor($user);

        $this->assertCount(1, $schema['hasCredential']);
        $credential = $schema['hasCredential'][0];
        $this->assertSame('EducationalOccupationalCredential', $credential['@type']);
        $this->assertSame($expertise->code, $credential['name']);
        $this->assertSame(
            $expertise->date_of_expiration->toDateString(),
            $credential['expires']
        );
    }

    /**
     * An expired registration is not vouched for in the structured data, which
     * would otherwise contradict what the page itself says.
     */
    public function testExpiredRegistrationIsNotDescribedAsCredential()
    {
        $user = User::factory()->create();
        Expertise::factory()->expired()->create(['user_id' => $user->id]);

        $schema = $this->schemaFor($user);

        $this->assertArrayNotHasKey('hasCredential', $schema);
    }

    /**
     * The block has to be valid JSON, since anything else is worse than
     * emitting nothing at all.
     */
    public function testStructuredDataIsValidJson()
    {
        $user = User::factory()->create();
        Expertise::factory()->create(['user_id' => $user->id]);

        $json = $this->rawSchemaFor($user);

        $this->assertNotNull(json_decode($json, true));
        $this->assertSame(JSON_ERROR_NONE, json_last_error());
    }

    /**
     * Pull the decoded ld+json block out of the rendered page.
     *
     * @param User $user
     *
     * @return array<string, mixed>
     */
    private function schemaFor(User $user): array
    {
        return json_decode($this->rawSchemaFor($user), true);
    }

    /**
     * Pull the raw ld+json block out of the rendered page.
     *
     * @param User $user
     *
     * @return string
     */
    private function rawSchemaFor(User $user): string
    {
        $response = $this->get(route('expert.show', ['user' => $user->cyber_code]));
        $response->assertStatus(200);

        $this->assertMatchesRegularExpression(
            '#<script type="application/ld\+json"[^>]*>(.+?)</script>#s',
            $response->getContent()
        );
        preg_match(
            '#<script type="application/ld\+json"[^>]*>(.+?)</script>#s',
            $response->getContent(),
            $matches
        );

        return $matches[1];
    }
}
