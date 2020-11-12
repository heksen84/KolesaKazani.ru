<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Session;

class SiteSearch extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testExample() {

    $this->withoutMiddleware();

/*    Session::start();
   
    $params = [
        'key'    => 'value',
        '_token' => csrf_token()
    ];

    $response = $this->call('GET', '/', $params);
    $response->assertSuccessful();*/

    $response = $this->get('/search?searchString=продам');
    $response->assertSuccessful();

//    $response = $this->get('/objavlenie/show/49-eeeeeeeeeeeeeeee-v-aksu');
//    $response->assertSuccessful();


    }
}
