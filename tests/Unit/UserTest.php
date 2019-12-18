<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;

class UserTest extends TestCase
{
 /*
  "adv_subcategory" => "17"
  "adv_info" => "test"
  "adv_price" => "50000"
  "adv_phone" => "(777) 777-7777"
  "adv_title" => "test 1111"
  "adv_category" => "3"
  "region_id" => "2061"
  "city_id" => "2063"
  "adv_coords" => "52.040616,76.926367"*/

    public function testBasicExample()
    {

	Session::start();

	 $credentials = array(
            'username' => '123@mail.ru',
            'password' => '111111',
            '_token' => csrf_token()
        );

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', 'http://flix:90/kz/api/createAdvert', [  
	
	"adv_subcategory" => "17", 
	"adv_info" => "test",  
	"adv_price" => "50000",   
	"adv_phone" => "(777) 777-7777",  
	"adv_title" => "test 1111",
        "adv_category" => "3",
        "region_id" => "2061",
        "city_id" => "2063",
        "adv_coords" => "52.040616,76.926367"

	],  $credentials);

        $response->assertStatus(200);
    }

/*    public function testBasicExample()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('GET', 'http://flix:90/kz/api/getCarsMarks');

        $response->assertStatus(200);
    }*/

}