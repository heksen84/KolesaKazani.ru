<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Orgs;
use DB;

class OrgsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
	return Categories::all()->toJson();
    }

    public function getInfo() {
	return "In progress...";
    }

    public function getOrgs(Request $request) {
	return Categories::all()->toJson();
    }

    public function addCompany(Request $request) {


/*       $url = array( "http://151.80.37.10:8080/tollfreenumber?query=",
		     "http://151.80.37.10:5000/inter800?query=",
		     "http://151.80.37.10:5000/tollfreeda?query=");


       	    // 3 server from database
      	    /*if ($request->server_index == 3 ) {
		return json_encode(Orgs::where('company_name', $request->name)->get());
       	    }*/

//       	return $request->name;

/*	for ( $i=0; $i<3; $i++ ) {	
           $json = file_get_contents($url[$i].$request->name);		
   	   if ($json) {
                $dec = json_decode(str_replace(array("\r", "\n"), '', $json ), true);
   		if (!$dec) return "addCompany: Bad json!";
   		for( $j=0; $j<count($dec); $j++ ) {
                 if (strtoupper($dec[$j]["Company Name: "]) == strtoupper($request->name) || strtoupper($dec[$j]["Number: "]) == strtoupper($request->number)) return "found";
             	}
              }
	   }
*/

	if (DB::table('orgs')->insert(['id' => null, 'number' => $request->number, 'company_name' => $request->name, 'business_info' => $request->orginfo, 'website' => $request->website, 'category_id' => $request->category_id, 'country_id' => $request->country_id]))
	return "Record added";
	return "Error append record";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
