<?php

namespace Kustomrt\LaravelSimpleApiKey\tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LaravelSimpleApiKeyTests extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_return_401_with_no_api_key(): void
    {
        $response = $this->get('/');

        $response->assertStatus(401);
    }

    public function test_return_403_with_invalid_api_key(): void
    {
        $response = $this->get('/', [
            'Authorization' => 'Bearer 0123456789'
        ]);

        $response->assertStatus(403);
    }
}
