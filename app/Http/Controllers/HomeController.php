<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Video;

class HomeController extends Controller {

    /**
     * Homepage
     */
    public static function index() {
        if (!empty($_GET['setCate'])) {
            Video::categories_crawler();
        }
        if (!empty($_GET['setCountry'])) {
            Video::countries_crawler();
        }
        Video::video_crawler();
        return view('home.index');
    }

}
