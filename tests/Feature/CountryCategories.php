<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CountryCategories extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample() {

        $this->withoutMiddleware();
        $response = $this->get('/c/transport');

        $response->assertStatus(200);
    }
}
