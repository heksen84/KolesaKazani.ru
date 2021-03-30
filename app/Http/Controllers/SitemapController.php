<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\Common;
use App\SE_UserQueries;

class SitemapController extends Controller {

    public function getUrls(Request $request) {
     return response()->view('sitemap', [ 'results' => SE_UserQueries::All() ])->header('Content-Type', 'text/xml');
}
}

