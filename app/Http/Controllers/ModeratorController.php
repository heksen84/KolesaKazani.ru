<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adverts;

class ModeratorController extends Controller {

    public function showHomePage(Request $request) {
        return view("moderator")
        ->with("title", "панель модератора")
        ->with("description", "панель модератора")
        ->with("keywords", "панель модератора")
        ->with("adverts", Adverts::all());
    }

}
