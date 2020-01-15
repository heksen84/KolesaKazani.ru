<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModeratorController extends Controller {

    public function showHomePage(Request $request) {
	return view("moderator");
    }

}
