<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$pass = bcrypt('e2dea11207209fe4036a8bd32d32ae83ddf088bed0400d5ebf044e217796ad52');


      // echo 'password: ' . $pass;
        return view('home');
       /*
       $id = 5;
       $header = "#EXTM3U";
       $footer = "#EXT-X-ENDLIST";

       $file = $id ."/m3u8/playlist.m3u8"; //playlist.m3u8 path
       $conn = Storage::disk('streaming'); //which disk
       $stream = $conn->readStream($file);

       $collection = collect(); // initialize empty collection
       while (($line = fgets($stream, 4096)) !== false) // iterate playlist.m3u8 line by line
       {
           $collection->push($line); // push every line into $collection
       }

       // put $header on top of the collection
       $collection->prepend($header);

       // put $footer on bottom of the collection
       $collection->push($footer);

       // write to file
       Storage::disk('streaming')->put( $id . "/m3u8/playlist.m3u8" ,  $collection->all()); 
       */
    }
}
