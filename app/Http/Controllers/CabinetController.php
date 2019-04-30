<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Adverts;

class CabinetController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {

        $items = DB::table('adverts')->where('user_id', Auth::id())->select('id','text')->get();
        return view('cabinet')->with("items", json_encode($items ));
    }
}
