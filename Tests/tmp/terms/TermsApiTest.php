<?php

namespace Modules\Shop\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Shop\Models\Terms;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class TermsApiTest extends TestCase
{

    use RefreshDatabase;


    protected function setUp(): void
    {

        parent::setUp();

        $this->user = User::factory()->create();

    }


    /** @test */
    public function it_can_list_terms()
    {

        Terms::factory()->count(3)->create();

        $url = route('api.shop.terms.index');

        $response = $this->getJson($url);

        $response->assertOk();

    }


    /** @test */
    public function it_can_show_a_single_term()
    {

        $term = Terms::factory()->create();

        $url = route('api.shop.terms.show', $term->id);

        $response = $this->getJson($url);

        $response->assertOk();

    }


    /** @test */
    public function it_can_create_a_term()
    {

        $url = route('api.shop.terms.store');

        $payload = [
            'title' => 'Vilkår',
            'content' => [
                'da' => 'Danske vilkår',
                'en' => 'English terms',
            ],
        ];

        $response = $this->actingAs($this->user)->postJson($url, $payload);

        $response->assertCreated();


    }


    /** @test */
    public function it_can_update_a_term()
    {

        $term = Terms::factory()->create([
            'title' => 'Gamle vilkår',
        ]);

        $url = route('api.shop.terms.update', $term->id);

        $payload = [
            'title' => 'Opdaterede vilkår',
            'content' => [
                'da' => 'Opdateret indhold',
                'en' => 'Updated content',
            ],
        ];

        $response = $this->actingAs($this->user)->putJson($url, $payload);

        $response->assertOk();

    }


    /** @test */
    public function it_can_delete_a_term()
    {
        $term = Terms::factory()->create();

        $url = route('api.shop.terms.destroy', $term->id);

        $response = $this->actingAs($this->user)->deleteJson($url);

        $response->assertnoContent();

        // Tjek at den er "soft deleted" (deleted_at sat)
        $this->assertDatabaseMissing('shop_terms', ['id' => $term->id]);
    }


}
