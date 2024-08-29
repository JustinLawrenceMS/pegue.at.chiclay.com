<?php

namespace Tests\Feature\Http\Controllers\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PegueControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_citation_endpoint_is_reachable(): void
    {
        $response = $this->post('api/v1/citation', ['citation' => 'Ivanovic, J., Baltic, M. Z., Janjic, J., Markovic, R., Baltic, T., Boskovic, M., ... & Jovanovic, D. (2016). Health aspects of dry-cured ham. Scientific journal" Meat Technology", 57(1), 43-50.']);
        $response->assertStatus(200);
    }
}
