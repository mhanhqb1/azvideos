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
        Video::video_crawler();
        return view('home.index');
    }

}
