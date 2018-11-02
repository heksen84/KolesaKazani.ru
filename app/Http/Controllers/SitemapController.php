<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public static function addUrl($url) {
        \Debugbar::info($url);
    }
    public static function removeUrl($url) {
        \Debugbar::warning($url);
    }
}
