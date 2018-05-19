<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Vinelab\Http\Client as HttpClient;
use App\Numbers;
use App\Orgs;
use DB;

function jsonFixer($json){
    $patterns     = [];
    /** garbage removal */
    $patterns[0]  = "/([\s:,\{}\[\]])\s*'([^:,\{}\[\]]*)'\s*([\s:,\{}\[\]])/"; //Find any character except colons, commas, curly and square brackets surrounded or not by spaces preceded and followed by spaces, colons, commas, curly or square brackets...
    $patterns[1]  = '/([^\s:,\{}\[\]]*)\{([^\s:,\{}\[\]]*)/'; //Find any left curly brackets surrounded or not by one or more of any character except spaces, colons, commas, curly and square brackets...
    $patterns[2]  =  "/([^\s:,\{}\[\]]+)}/"; //Find any right curly brackets preceded by one or more of any character except spaces, colons, commas, curly and square brackets...
    $patterns[3]  = "/(}),\s*/"; //JSON.parse() doesn't allow trailing commas
    /** reformatting */
    $patterns[4]  = '/([^\s:,\{}\[\]]+\s*)*[^\s:,\{}\[\]]+/'; //Find or not one or more of any character except spaces, colons, commas, curly and square brackets followed by one or more of any character except spaces, colons, commas, curly and square brackets...
    $patterns[5]  = '/["\']+([^"\':,\{}\[\]]*)["\']+/'; //Find one or more of quotation marks or/and apostrophes surrounding any character except colons, commas, curly and square brackets...
    $patterns[6]  = '/(")([^\s:,\{}\[\]]+)(")(\s+([^\s:,\{}\[\]]+))/'; //Find or not one or more of any character except spaces, colons, commas, curly and square brackets surrounded by quotation marks followed by one or more spaces and  one or more of any character except spaces, colons, commas, curly and square brackets...
    $patterns[7]  = "/(')([^\s:,\{}\[\]]+)(')(\s+([^\s:,\{}\[\]]+))/"; //Find or not one or more of any character except spaces, colons, commas, curly and square brackets surrounded by apostrophes followed by one or more spaces and  one or more of any character except spaces, colons, commas, curly and square brackets...
    $patterns[8]  = '/(})(")/'; //Find any right curly brackets followed by quotation marks...
    $patterns[9]  = '/,\s+(})/'; //Find any comma followed by one or more spaces and a right curly bracket...
    $patterns[10] = '/\s+/'; //Find one or more spaces...
    $patterns[11] = '/^\s+/'; //Find one or more spaces at start of string...

    $replacements     = [];
    /** garbage removal */
    $replacements[0]  = '$1 "$2" $3'; //...and put quotation marks surrounded by spaces between them;
    $replacements[1]  = '$1 { $2'; //...and put spaces between them;
    $replacements[2]  = '$1 }'; //...and put a space between them;
    $replacements[3]  = '$1'; //...so, remove trailing commas of any right curly brackets;
    /** reformatting */
    $replacements[4]  = '"$0"'; //...and put quotation marks surrounding them;
    $replacements[5]  = '"$1"'; //...and replace by single quotation marks;
    $replacements[6]  = '\\$1$2\\$3$4'; //...and add back slashes to its quotation marks;
    $replacements[7]  = '\\$1$2\\$3$4'; //...and add back slashes to its apostrophes;
    $replacements[8]  = '$1, $2'; //...and put a comma followed by a space character between them;
    $replacements[9]  = ' $1'; //...and replace by a space followed by a right curly bracket;
    $replacements[10] = ' '; //...and replace by one space;
    $replacements[11] = ''; //...and remove it.

    $result = preg_replace($patterns, $replacements, $json);

    return $result;
  }

class SearchController extends Controller {
    public function Search(Request $request) {
	     return view('search')->with("search_string", $request->company);
    }

    public function browseFromCategory(Request $request) {
      /*

      Products::whereIn('id', function($query){
        $query->select('paper_type_id')
        ->from(with(new ProductCategory)->getTable())
        ->whereIn('category_id', ['223', '15'])
        ->where('active', 1);
      })->get();

      */
		       return json_encode(Orgs::where('company_name', $request->org_name)->get());

    }

    public function getOrgList(Request $request) {

        $attachment_ids = array();

	       $url = array( "http://151.80.37.10:8080/tollfreenumber?query=",
			                 "http://151.80.37.10:8080/inter800?query=",
			                 "http://151.80.37.10:8080/tollfreeda?query=");

       // 3 server from database
       if ($request->server_index == 3 )
		       return json_encode(Orgs::where('company_name', $request->org_name)->get());

       // 0 server
       if ($request->server_index==0){
         $json = file_get_contents($url[$request->server_index].$request->org_name);

   	     if ($json) {
                $dec = json_decode(str_replace(array("\r", "\n"), '', $json ), true);
   		           if (!$dec) return "Bad json";
   		             for($i=0;$i<count($dec);$i++){
           		         $attachment_ids[] = array(
             		           "number" => $dec[$i]["Number: "],
             		             "company_name" => $dec[$i]["Company Name: "],
             		             //  "business_info" => $dec[$i]["Business Info: "],
             		                 "website" => "site-".$i,
             		                   "location" => "123",
             		                     "categories" => "123");
           		                       }
                                      return $attachment_ids;
              }

              return "server_error_500";
       }

       // 1 server
       if ($request->server_index==1){

         $json = file_get_contents($url[$request->server_index].$request->org_name);

   	     if ($json) {
                $dec = json_decode(str_replace(array("\r", "\n"), '', $json ), true);
   		           if (!$dec) return "Bad json";
   		             for($i=0;$i<count($dec);$i++){
           		         $attachment_ids[] = array(
             		           "number" => $dec[$i]["Number: "],
             		             "company_name" => $dec[$i]["Company Name: "],
             		             //  "business_info" => $dec[$i]["Business Info: "],
             		                 "website" => "site-".$i,
             		                   "location" => "123",
             		                     "categories" => "123");
           		                       }
                                      return $attachment_ids;
              }
              return "server_error_500";
       }

       // 2 server
       if ($request->server_index==2){

         $json = file_get_contents($url[$request->server_index].$request->org_name);

   	     if ($json) {
                $dec = json_decode(str_replace(array("\r", "\n"), '', $json ), true);
   		           if (!$dec) return "Bad json";
   		             for($i=0;$i<count($dec);$i++){
           		         $attachment_ids[] = array(
             		           "number" => $dec[$i]["Number: "],
             		             "company_name" => $dec[$i]["Company Name: "],
             		             //  "business_info" => $dec[$i]["Business Info: "],
             		                 "website" => "site-".$i,
             		                   "location" => "123",
             		                     "categories" => "123");
           		                       }
                                      return $attachment_ids;
              }
              return "server_error_500";
       }

      return null;
    }

    public function create() {
    }

    public function store(Request $request) {
    }

    public function show($id) {
    }

    public function edit($id) {
    }

    public function update(Request $request, $id) {
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
