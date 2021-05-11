<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function login() {
        return view('admin');
    }

    public function parseOlx() {

        $outout = "";
        exec("php artisan parse:olx", $output);
        
        return $output;
    }
}
