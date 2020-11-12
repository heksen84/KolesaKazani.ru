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

        $response = $this->get('/c/transport/legkovoy-avtomobil');
        $response->assertStatus(200);

        $response = $this->get('/c/transport/gruzovoy-avtomobil');
        $response->assertStatus(200);

        $response = $this->get('/c/transport/mototehnika');
        $response->assertStatus(200);

        $response = $this->get('/c/transport/spectehnika');
        $response->assertStatus(200);

        $response = $this->get('/c/transport/retro-avtomobil');
        $response->assertStatus(200);

        $response = $this->get('/c/transport/vodnyy-transport');
        $response->assertStatus(200);

        $response = $this->get('/c/transport/velosiped');
        $response->assertStatus(200);

        $response = $this->get('/c/transport/vozdushnyy-transport');
        $response->assertStatus(200);

        $response = $this->get('/c/transport/zapchasti');
        $response->assertStatus(200);
        
        $response = $this->get('/c/nedvizhimost');
        $response->assertStatus(200);

        $response = $this->get('/c/nedvizhimost/kvartira');
        $response->assertStatus(200);

        $response = $this->get('/c/nedvizhimost/komnata');
        $response->assertStatus(200);

        $response = $this->get('/c/nedvizhimost/dom-dacha-kottedzh');
        $response->assertStatus(200);

        $response = $this->get('/c/nedvizhimost/zemelnyy-uchastok');
        $response->assertStatus(200);

        $response = $this->get('/c/nedvizhimost/garazh-ili-mashinomesto');
        $response->assertStatus(200);

        $response = $this->get('/c/nedvizhimost/kommercheskaya-nedvizhimost');
        $response->assertStatus(200);

        $response = $this->get('/c/nedvizhimost/nedvizhimost-za-rubezhom');
        $response->assertStatus(200);                

        /*$response = $this->get('/c/nedvizhimost/nedvizhimost-za-rubezhom');
        $response->assertStatus(200);*/

    }
}
