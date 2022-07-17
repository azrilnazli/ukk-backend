<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TenderSubmission;
use App\Models\Video;
use App\Models\User;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Facades\DB;
use App\Models\VideoLog;
use App\Actions\Stats;
use App\Actions\Logger;

use App\Models\Company;
use App\Models\Comment;

class CollectionsController extends Controller
{
    public function index()
    {
       return $this->pluck();
    }

    // The all method returns the underlying array represented by the collection
    public function all()
    {

        $cars = collect(['nissan','proton','daihatsu', 'perodua','renault']);

        return $cars->all();
    }

    // The combine method combines the values of the collection,
    // as keys, with the values of another array or collection:
    public function combine()
    {
        $collection = collect(['brand', 'country']);

        $combined = $collection->combine(['mazda', 'japan']);


        return $combined->all();

    }

    public function contains()
    {
        $videos = Video::all();

        //contains($key, $operator = null, $value = null)

        if( $videos->contains('title', '=' , 'Cloud TM') ){
            echo 'true';
        } else {
            echo 'false';
        }
    }


    public function merge()
    {
        $brands = collect(['mazda', 'honda', 'toyota', 'daihatsu', 'subaru']);

        $malaysia = collect(['proton', 'perodua']);

        $merged = $brands->merge($malaysia);

        return $merged->all();
    }

    public function chunk()
    {
        $cars = collect(['mazda', 'honda', 'toyota', 'daihatsu', 'subaru','nissan']);

        $chunks = $cars->chunk(2);

        return $chunks->all();

    }

    // The concat method appends
    // the given array or collection's
    // values onto the end of another collection:
    public function concat()
    {
        $cars = collect(['mazda', 'honda', 'toyota', 'daihatsu', 'subaru','nissan']);
        $cars = $cars->concat(['proton']);
        return $cars->all();
    }



    // The collapse method collapses a collection
    // of arrays into a single, flat collection:
    public function collapse()
    {
        $japan = ['mazda', 'honda', 'toyota', 'daihatsu', 'subaru','nissan'];
        $germany = ['BMW', 'mercedes', 'audi', 'open', 'mini','range rover'];
        $malaysia = ['proton', 'perodua'];

        $cars = collect([$japan,$germany,$malaysia]);
        $collapsed = $cars->collapse();

        return $collapsed->all();

    }




    // The countBy method counts the occurrences of values in the collection. By default,
    // the method counts the occurrences of every element, allowing you to count
    // certain "types" of elements in the collection:
    public function countBy()
    {
        $emails = [
                'skyline@nissan','silvia@nissan',
                'nsx@honda','civic@honda',
                'supra@toyota', 'ae86@toyota','gt86@toyota',
                'evolution@mitsubishi', 'pajero@mitsubishi',
                'mira@daihatsu'
        ];

        $collection = collect($emails);

        $counted = $collection->countBy( function ($email) {

            // The strrchr() function finds the position of the last occurrence of a string
            // within another string, and returns all characters from this position
            // to the end of the string.
            $brand = strrchr($email,"@"); // will return @nissan or @honda

            // The substr() function returns a part of a string.
            // 1 here means first character which is @
            $brand = substr( $brand, 1); // remove the @

            return $brand; // return the brand

        });

        return $counted->all();
    }




    // The diff method compares the collection against another collection or a plain
    // PHP array based on its values. This method will return the values in the original
    // collection that are not present in the given collection:

    public function diff()
    {

        $brands1 = collect(['Honda', 'Toyota', 'Nissan']);
        $brands2 = collect(['Honda', 'Mitsubishi', 'Nissan']);

        $diff1 = $brands1->diff($brands2);
        $diff2 =  $brands2->diff($brands1);
        return $diff2->all();

    }



    // The each method iterates over the items in
    // the collection and passes each item to a closure:
    public function each()
    {

        $cars = collect(['mazda', 'honda', 'toyota', 'daihatsu', 'subaru','nissan']);

        $cars->each( function ( $car, $key) {

            echo "Key is $key and valus is $car" . PHP_EOL;

        });

        echo "----------------------" . PHP_EOL;

        $cars->each( function ( $car, $key) {

            echo "Key is $key and valus is $car" . PHP_EOL;
            if($car == 'daihatsu')
            {
                return FALSE;
            }
        });

    }





    // The eachSpread method iterates over the collection's items
    // passing each nested item value into the given callback:

    function eachSpread()
    {
        $collection = collect([
            ['mazda', 'japan'],
            ['proton', 'malaysia'],
            ['bmw', 'germany'],
            ['tata', 'india'],
            ['geely', 'china']

        ]);

        $collection->eachSpread(function ($car, $country) {

            echo "$car is from $country" . PHP_EOL;

        });
    }



    // The every method may be used to verify that
    // all elements of a collection pass a given truth test:
    function every()
    {

        $number = collect([1, 2, 3, 4])->every(function ($value, $key) {
            return $value > 0;
        });

        echo $number ? 'true' : 'false' ;

        echo PHP_EOL;


        $number = collect([1, 2, 3, 4])->every(function ($value, $key) {
            return $value > 2;
        });

        echo $number ? 'true' : 'false';

    }



    // The except method returns all items in the
    // collection except for those with the specified keys:
    function except()
    {
        $collection = collect([
                'car_model' => 'mazda',
                'car_id' => 1,
                'price' => 100,
                'discount' => false
            ]);

        $filtered = $collection->except(['price', 'discount']);

       return $filtered->all();
    }


    // The filter method filters the collection using
    // the given callback, keeping only those items that pass a given truth test:

    function filter()
    {

        $countries = [
            '1' => 'malaysia',
            '2' => 'thailand',
            '3' => 'singapore',
            '4' => 'indonesia',
        ];
        $collection = collect($countries)
                        ->each( function ( $value,$key)
                        {
                            echo "value is $value key is $key". PHP_EOL;

                        })->filter( function($country, $key) {
                            return $country == 'malaysia';
                        })->all();

        return $collection;
    }



    // The pluck method retrieves all of the values for a given key:

    function pluck(){

        $collection = collect([
            [
                'cars' => [
                    'japan'     => [
                                    'mazda'     =>   ['mx-5', 'rx-7', 'rx-8'],
                                    'honda'     =>   ['civic', 'city','accord', 'nsx'],
                                    'toyota'    =>   [ 'corolla', 'celica' , 'supra'],
                                    'daihatsu'  =>   ['mira', 'charade'],
                                    'subaru'    =>   ['impreza' ,'forester'],
                                    'nissan'    =>   ['almera', 'skyline', 'sentra']
                                    ],

                    'malaysia'  => ['proton', 'perodua'],
                    'india'     => ['tata'],
                    'germany'   => ['bmw', 'audi', 'opel', 'mercedes', 'volkswagen'],
                ],
            ],
        ]);

        // $collection->pluck('cars')->dd();

        // $collection->pluck('cars.japan')->dd();
        $collection->pluck('cars.japan.mazda')->dd();


    }



    // The pop method removes and returns the last item from the collection:
    function pop(){

        $collection = collect(['mazda','nissan','honda','toyota','proton']);


        //$collection->pop(1);
        //$collection->pop(2);
        //$collection->pop(3);
        //$collection->pop(4);
        $collection->pop(5);

        return $collection->all();
    }



    // The prepend method adds an item to the beginning of the collection:

    function prepend(){
        $collection = collect(['mazda','nissan']);

        $collection->prepend('honda');

        return $collection->all();
    }



    // The sum method returns the sum of all items in the collection:
    function sum(){

        $collection = collect([

            ['brand' => 'mazda', 'price' => 120000 ],
            ['brand' => 'honda', 'price' => 150000 ],
            ['brand' => 'nissan', 'price' => 180000 ],
            ['brand' => 'proton', 'price' => 130000 ],
        ]);

        // jumlahkan harga
        return $collection->sum('price');

    }




    function collect()
    {


        $vehicles =

                [
                    (object)([
                            'model' => 'skyline',
                            'price' => 250000,
                            'horsepower' => 280,
                            'turbo' => true
                            ]), // skyline

                    (object) ([
                            'model' => 'silvia',
                            'price' => 150000,
                            'horsepower' => 200,
                            'turbo' => true
                             ]), // silvia

                ]; // array


        $collection = collect($vehicles);

        foreach ($collection as $product)
        {
            echo $product->model . PHP_EOL;
        }

        $collection->each( function ($value, $key)
        {
            echo $value->model . PHP_EOL;
        });

    }

    function multi()
    {


        // $collection = collect([
        //     [
        //         'cars' =>
        //         [
        //             'japan'     => [
        //                                 'mazda'     =>   ['mx-5', 'rx-7', 'rx-8'],
        //                                 'honda'     =>   ['civic', 'city','accord', 'nsx'],
        //                                 'toyota'    =>   ['corolla', 'celica' , 'supra'],
        //                                 'daihatsu'  =>   ['mira', 'charade'],
        //                                 'subaru'    =>   ['impreza' ,'forester'],
        //                                 'nissan'    =>   [
        //                                                     'almera',
        //                                                     'sentra',
        //                                                     'skyline' => [
        //                                                                     'model' => 'skyline',
        //                                                                     'price' => 250000,
        //                                                                     'horsepower' => 280,
        //                                                                     'turbo' => true
        //                                                                 ] // skyline
        //                                                 ] // nissan
        //                             ],

        //             'malaysia'  => ['proton', 'perodua'],
        //             'india'     => ['tata'],
        //             'germany'   => ['bmw', 'audi', 'opel', 'mercedes', 'volkswagen'],
        //         ],
        //     ],
        // ]); // collection



        $cars = [
            'brand' =>  [
                            'mazda' =>  [
                                            'model' => [
                                                            'mx-5' =>   [
                                                                            'price' => 130000,
                                                                            'horsepower' => 120,
                                                                            'turbo' => false,
                                                                            'layout' => 'rwd',
                                                                            'code' => 'ND',
                                                                            'year' => 2016
                                                                        ],
                                                            'rx-7' =>   [
                                                                            'price' => 250000,
                                                                            'horsepower' => 280,
                                                                            'turbo' => true,
                                                                            'layout' => 'rwd',
                                                                            'code' => 'FD',
                                                                            'year' => 2001
                                                                        ],
                                                            'rx-8' =>   [
                                                                            'price' => 200000,
                                                                            'horsepower' => 200,
                                                                            'turbo' => false,
                                                                            'layout' => 'rwd',
                                                                            'code' => 'SE3P',
                                                                            'year' => 2005
                                                                        ],
                                                        ], // model
                                        ],  // mazda
                                'honda' =>  [
                                            'model' => [
                                                            'civic' =>   [
                                                                            'price' => 75000,
                                                                            'horsepower' => 70,
                                                                            'turbo' => false,
                                                                            'layout' => 'fwd',
                                                                            'code' => 'FB',
                                                                            'year' => 2021
                                                                        ],
                                                            'accord' =>   [
                                                                            'price' => 180000,
                                                                            'horsepower' => 150,
                                                                            'turbo' => false,
                                                                            'layout' => 'fwd',
                                                                            'code' => 'SV8',
                                                                            'year' => 2020
                                                                        ],
                                                            'city' =>   [
                                                                            'price' => 50000,
                                                                            'horsepower' => 50,
                                                                            'turbo' => false,
                                                                            'layout' => 'fwd',
                                                                            'code' => 'CITY',
                                                                            'year' => 2009
                                                                        ],
                                                        ], // model


                                        ]  // mazda
                        ], // brand
        ];



        $collection = collect($cars);

        // senaraikan model Mazda
        $collection->pluck('mazda.model') // pluck
                   ->each( function ($value, $key) // print_r($value)
                    {
                        collect($value)->each( function ($value, $key) // collect again
                        {
                            echo $key . PHP_EOL; // echo
                        });
                    });



        // get the horsepower value for Nissan Skyline

    } // func

    function manufacturer()
    {
        $manufacturer = [
        [
            'name' => 'mazda',
            'cars' => [
                [
                    'model' => 'cx-5',
                    'price' => 130000,
                    'horsepower' => 120,
                    'turbo' => false,
                    'layout' => 'rwd',
                    'code' => 'FD',
                    'year' => 2016
                ],
                [
                    'model' => 'cx-3',
                    'price' => 90000,
                    'horsepower' => 100,
                    'turbo' => false,
                    'layout' => 'rwd',
                    'code' => 'FD',
                    'year' => 2013
                ]
            ]
        ],
        [
            'name' => 'toyota',
            'cars' => [
                [
                    'model' => 'trueno',
                    'price' => 130000,
                    'horsepower' => 120,
                    'turbo' => false,
                    'layout' => 'rwd',
                    'code' => 'FD',
                    'year' => 2016
                ],
                [
                    'model' => 'fortuner',
                    'price' => 90000,
                    'horsepower' => 100,
                    'turbo' => false,
                    'layout' => 'rwd',
                    'code' => 'FD',
                    'year' => 2013
                ]
            ]
        ]
    ];// manufacturer



        // list manufacturer and its model
        // collect($manufacturer)->each( function( $value, $key ){
        //     //print_r($key) . PHP_EOL;
        //     echo $value['name'] . ' = ';
        //     collect($value['cars'])->each( function( $value, $key ){
        //         collect($value['model'])->each( function( $value, $key ){
        //            echo $value . ',';
        //         });
        //     });
        //     echo PHP_EOL;
        // });

        // list only mazda
        // $mazda = collect($manufacturer)->filter( function($value){
        //     return $value['name'] == 'mazda';
        // });

        // print_r( $mazda->all() ); // only mazda

        // get the price for Mazda cx-3
        //$mazda->pluck('cars.0.price')->dump();

        // get horsepower for toyota trueno

        // list only toyota
       // $toyota = collect($manufacturer)->where('name', 'toyota')->pluck('cars');

        //get only toyotas
        $models = collect($manufacturer)
                    ->filter(function ($value, $key)
                    {
                        return collect($value['name'])
                                ->contains('toyota');
                    })
                    ->collapse()
                    ->toArray();


        print_r($models);


        // get toyota trueno price
        $price = collect($models['cars'])
                ->where('model','trueno')
                ->pluck('price')
                ->shift();

         //dd($price);
        echo "Price for Trueno is  $price" . PHP_EOL;

        // get toyota trueno price
        $year = collect($models['cars'])
        ->where('model','fortuner')
        ->pluck('year')
        ->shift();

         //dd($price);
        echo "Year for Fortuner is  $year";

    }


    function map()
    {

        $collection = collect(['mazda','toyota','honda'])->dump();

        $capital = $collection->map( function($value){
            return strToUpper($value);
        });

        $capital->dump();

    }

    function only()
    {

        $detail = collect(
            [
                'model' => 'cx-5',
                'price' => 130000,
                'horsepower' => 120,
                'turbo' => false,
                'layout' => 'rwd',
                'code' => 'FD',
                'year' => 2016
            ]
        );

        $detail->only('year')->dump();
        $detail->only('price')->dump();
        $detail->only('layout')->dump();
    }


    function pipe()
    {
        $price = collect(
            [
                'exhaust' => 1200,
                'wheels' => 500,
                'steering' => 120,
                'turbo' => 750,
                'seats' => 1200,
                'tints' => 250,
                'paint' => 1200
            ]
        );

        $total = $price->flatten()->pipe( function($value){

            return $value->sum();

        });

        dd($total);

    }

    function access_log()
    {

        $log_file = 'C:\laragon\bin\apache\httpd-2.4.47-win64-VS16\logs\access.log';
        //$pattern = '/^([^ ]+) ([^ ]+) ([^ ]+) (\[[^\]]+\]) "(.*) (.*) (.*)" ([0-9\-]+) ([0-9\-]+) "(.*)" "(.*)"$/';
        $pattern = '/^(\S+)\ (\S+) (\S+) \\[(.*?)\\] \\"(.*?)\\" (\S+) (\S+) (\S+)\z/';
        //$pattern = "/^(\S+) (\S+) (\S+) \[([^:]+):(\d+:\d+:\d+) ([^\]]+)\] \"(\S+) (.*?) (\S+)\" (\S+) (\S+) "([^"]*)" "([^"]*)"$/";
        //$pattern = '/^(\S+) \S+ \S+ \[([^\]]+)\] "([A-Z]+)[^"]*" \d+ \d+ "[^"]*" "([^"]*)"$/m';
        // $pattern = '/^(?P<IP>\S+)
        // \ (?P<ident>\S)
        // \ (?P<auth_user>.*?) # Spaces are allowed here, can be empty.
        // \ (?P<date>\[[^]]+\])
        // \ "(?P<http_start_line>.+ .+)" # At least one space: HTTP 0.9
        // \ (?P<status_code>[0-9]+) # Status code is _always_ an integer
        // \ (?P<response_size>(?:[0-9]+|-)) # Response size can be -
        // \ "(?P<referrer>.*)" # Referrer can contains everything: its just a header
        // \ "(?P<user_agent>.*)"$/x';
       // $pattern = '/^(\S+) (\S+) (\S+) \[([^:]+):(\d+:\d+:\d+) ([^\]]+)\] \"(\S+) (.*?) (\S+)\" (\S+) (\S+) "([^"]*)" "([^"]*)"$/';

        $fh = fopen($log_file,'r') or die($php_errormsg);
        $i = 1;
        $requests = array();
        while (! feof($fh))
        {

            // read each line and trim off leading/trailing whitespace
            if ($s = trim(fgets($fh,16384)))
            {
                echo $s;
                if (preg_match($pattern,$s,$matches))
                {
                    print_r('lepas');
                    /* put each part of the match in an appropriately-named * variable */
                    list($whole_match,$remote_host,$logname,$user,$time, $method,$request,$protocol,$status,$bytes,$referer, $user_agent) = $matches;
                    // keep track of the count of each request
                    $requests[$request]++;
                } else {
                    print_r("\n");
                    // complain if the line didn't match the pattern
                    // echo 'not match';
                    // error_log("Can't parse line $i: $s");
                } // if
                die();

            } // if

            $i++;

        } // while

        fclose($fh) or die($php_errormsg);

        // sort the array (in reverse) by number of requests
        arsort($requests);

        // print formatted results
        foreach ($requests as $request => $accesses)
        {
            printf("%6d %s\n",$accesses,$request);
        }


    }

    function split()
    {

        $log = '127.0.0.1 - - [07/Mar/2022:11:38:44 +0800] "GET /api/movie/6/playlist.m3u8/114%7CruDKlwRfNxLbIl4waAWIAOq83oZFEtWwncDt6Fok?access_token=114|ruDKlwRfNxLbIl4waAWIAOq83oZFEtWwncDt6Fok HTTP/1.1" 200 1358';

        //$pattern ='127.0.0.1 - - [07/Mar/2022:11:38:44 +0800] "GET /api/movie/6/playlist.m3u8/114%7CruDKlwRfNxLbIl4waAWIAOq83oZFEtWwncDt6Fok?access_token=114|ruDKlwRfNxLbIl4waAWIAOq83oZFEtWwncDt6Fok HTTP/1.1" 200 1358';
        $pattern ='127.0.0.1 - - [02/Mar/2022:17:09:58 +0800] "GET /api/movie/6/playlist.m3u8/65 HTTP/1.1" 206 1348';

        $regex = '/^(\S+)\ (\S+) (\S+) \\[(.*?)\\] \\"(.*?)\\" (\S+) (\S+)\z/';
        if (preg_match($regex,$pattern,$matches))
        {
            echo 'match';
            print_r($matches);
        } else {
            echo 'not match';
        }
    }



    function processLog()
    {


        //$regex = "/^(\S+) (\S+) (\S+) \[([^:]+):(\d+:\d+:\d+) ([^\]]+)\] \"(\S+) (.*?) (\S+)\" (\S+) (\S+) (\".*?\") (\".*?\")(\r?\n)$/";

        $log = 'C:\laragon\bin\apache\httpd-2.4.47-win64-VS16\logs\access.log';
        // 127.0.0.1 - - [14/Mar/2022:13:36:01 +0800] "GET /storage/streaming/12/m3u8/playlist_720p_0_2500_00010.ts HTTP/1.1" 200 769312
        $regex = '@^(\S+)\ (\S+) (\S+) \\[(.*?)\\] \\"GET \/storage\/streaming\/(.*?)\/m3u8\/(.*?).ts\?access_token\=(.*?) HTTP/1.1\\" (\S+) (\S+)(\r?\n)$@';

        LazyCollection::make(function () use ($log){

            $handle = fopen($log, 'r');

            while (($line = fgets($handle)) !== false){
                yield $line;
            }
            })->each(function ($line) use ($regex)
            {

               // echo $line . PHP_EOL;
                if (preg_match($regex,$line,$matches)){
                    //echo 'match' . PHP_EOL;
                    $d = $matches[4];
                    $time = date("Y-m-d H:i:s", strtotime($d));

                    // get video_id
                    $video_id = $matches[5];

                    // get bitrate
                    $r = explode('_',$matches[6]);
                    $bitrate = $r[1];

                    // get user_id
                    $r = explode('|',$matches[7]);
                    $token = $r[1];
                    $token_data = DB::table('personal_access_tokens')
                                    ->where('token', hash('sha256', $token))
                                    ->first();

                    //print_r($token_data);
                    $user_id = 0;
                    if($token_data){
                        $user_id = $token_data->tokenable_id;
                    }

                    $request = $matches[0];
                    $status = $matches[8];
                    $responseBytes = $matches[9];

                    $log = VideoLog::firstOrNew(
                                            [
                                                'request' => $request, // check before insert
                                            ]
                                        );
                    $log->time = $time;
                    $log->user_id =  $user_id;
                    $log->video_id = $video_id;
                    $log->bitrate = $bitrate;
                    $log->request = $request;
                    $log->status = $status;
                    $log->responseBytes = $responseBytes;
                    $log->save();

                }
            });

    } // lazy()




    function stats(){
        $stats = new Stats($user_id=2);
        $result = $stats->generate();
        print_r($result);
    }

    function total(){
        $stats = new Stats($user_id=2);
        $result = $stats->total();
        print_r($result);
    }

    function stats1(){
        $stats = new Stats($user_id=2);
        $result = $stats->all();

        $duration = collect($result)->sum('duration');
        $volume = collect($result)->sum('bytes');
        print_r($volume);
    }


    // process video logs from access_log
    // only GET requests
    function logger(){
        $logger = new Logger();

        while(true){
            sleep(2);
            $logger->processLog();
        }
    }

    function my_account(){
        $user = DB::table('users')
        // join all tables
        ->join('profiles', 'profiles.user_id', '=', 'users.id')
        // select required fields
        ->select(
            DB::raw('users.firstname'),
            DB::raw('users.lastname'),
            DB::raw('users.email'),
            DB::raw('profiles.address'),
            DB::raw('profiles.postcode'),
            DB::raw('profiles.city'),
            DB::raw('profiles.states'),
        )
        // belongs to who ?
        ->where('users.id', '17') // user_id
        ->limit(1)
        // get the Collection
        ->first();

        dd($user);

    }


    function get_company(){

        // company() & comments() methods in app/Models/User.php
        $user = User::query()->with('company','comments')->where('id',2)->first(); // hardcode user.id = 2

        echo $user->name; // user's name
        //echo $user->company->name; // company name ( Company belongsTo User)

        // all comments ( Comment belongsTo User )
        foreach($user->comments as $comment){
            echo $comment->message; // list of comments
        }
    }


    function get_comments(){
        $user_id = 2; // sanctum user_id
        $companies = Company::query()->with('comments')->get();

        foreach($companies as $company){
            foreach($company->comments as $comment){
                echo $company->id;
                echo $comment->message;
            }
        }
    }


    function latest_comment(){
        $user_id = 2; // sanctum user_id
        $companies = Company::query()->with('comments')->get();

        foreach($companies as $company){
            foreach($company->comments as $comment){
                echo $company->id;
                echo $comment->message;
            }
        }
    }

    function proposal(){

        $video = Video::firstOrNew(['user_id' =>  2 ]);

        $video->title = 'test 123';
        $video->category_id = 6;
        $video->original_filename = 'test.mp4';
        $video->synopsis = 'test.mp4';


        $video->save();
        // $video = User::query()->find(1)->video;
        dd($video->id);
    }

    function get_video(){
        $video = Video::query()
        ->where('user_id', 3)
        ->first();
        dd($video);
    }

    function save_video(){
        $proposal =   TenderSubmission::firstOrNew(['id' =>  1 ]);
        $proposal->video_id =12;
        $proposal->save();
    }

    function test_company(){
        $field = 'experiences';
        $company = Company::query()
        ->where('user_id', 4)
        ->get($field);

        if(is_null($company->first()->$field)){
            echo 'empty';
        } else {
            echo 'set';
        }
    }

    function test_requirement(){
        // get Company data
        $company = \App\Models\Company::where('user_id', 4 )->first();

        // load tenderDetail
        $tenderDetail = \App\Models\TenderDetail::with('tender_requirements')->find(4);

        //load tender requirements
        $requirements = $tenderDetail->tender_requirements;

        // load service
        $this->service = new \App\Services\CompanyApprovalService;
        // loop tender requirements and check each field is present
        $allow = true;

        foreach($requirements as $requirement){
            // echo $requirement->module;
            // echo PHP_EOL;
            // run the check
            // return true or false
            $module = $requirement->module;
            echo "checking for $module = ";
            $allow =  $this->service->$module();

            echo $allow ? 'pass' : 'failed';
            echo PHP_EOL;
            if(!$allow){
                break;
            }
        }
        echo $allow ? 'allow submit button' : 'button is disabled';
    }

    function test_status(){
        $company_approval = \App\Models\CompanyApproval::query()
        ->where('company_id',2)
        ->where('tender_detail_id',1)
        ->get('status');

        echo $approval_status = $company_approval->first()->status; // string
    }

    // function migrate_company_approved(){
    //     // create CompanyApproval
    //     // type = sambung_siri = tender_detail_id = 2
    //     // type = swasta = tender_detail_id = 2
    //     $proposals = \App\Models\TenderSubmission::query()
    //                 ->has('user.company')
    //                 ->distinct()
    //                 ->get();
    //     foreach($proposals as $key => $proposal){
    //         //echo $proposal->user_id;

    //         if($proposal->user->company->is_approved){


    //             // echo "company id - " . $proposal->user->company->id;
    //             // echo PHP_EOL;
    //             // echo "tender type - " . $proposal->tender->type;
    //             // echo PHP_EOL;

    //             if($proposal->tender->type){
    //                 $company[] = array(
    //                     'id' => $proposal->user->company->id,
    //                     'type' => $proposal->tender->type,
    //                 );
    //             }


    //         }


    //             // rejected company
    //             // if(!$proposal->user->company->is_approved){

    //             //     echo "proposal id  - " . $proposal->tender->id;
    //             //     echo " | tender type - " . $proposal->tender->type;
    //             //     echo " | category - " . $proposal->tender->programme_category;
    //             //     echo " | code - " . $proposal->tender->programme_code;
    //             //     //echo PHP_EOL;
    //             //     echo " | company name - " . $proposal->user->company->name;
    //             //     echo " | date  - " . $proposal->tender->updated_at;
    //             //     echo PHP_EOL;
    //             // }
    //         }
    //         $collection = collect($company)->unique()->each( function($val, $key) {

    //             // create CompanyApproval instance
    //             if($val['type'] == "SAMBUNG SIRI"){
    //                 echo $val['id'];
    //                 echo " - ";
    //                 echo $val['type'];
    //                 echo PHP_EOL;

    //                 $data['tender_detail_id'] = 1;
    //                 $data['company_id'] = $val['id'];
    //                 $data['is_approved'] = 1;
    //                 $data['status'] = 'approved';

    //                 \App\Models\CompanyApproval::create($data);

    //             }

    //             if($val['type'] == "SWASTA"){
    //                 echo $val['id'];
    //                 echo " - ";
    //                 echo $val['type'];
    //                 echo PHP_EOL;

    //                 $data['tender_detail_id'] = 2;
    //                 $data['company_id'] = $val['id'];
    //                 $data['is_approved'] = 1;
    //                 $data['status'] = 'approved';

    //                 \App\Models\CompanyApproval::create($data);

    //             }
    //         });

    //         echo "total : " . $collection->count();

    //     }


        public function migrate_company_approved(){
            echo "syarikat lulus : ";
            $companies = \App\Models\Company::query()
            ->where('is_approved', true)
            ->distinct()
            ->get();

            foreach($companies as $company){
                //$data['tender_detail_id'] = 1;

                // check which tender that company applied ?
                if($company->user->has('proposals')){
                    foreach($company->user->proposals as $proposal){

                        echo $proposal->tender->type;
                        echo PHP_EOL;
                        if($proposal->tender->type == "SAMBUNG SIRI"){
                            $data['tender_detail_id'] = 1;
                        }
                        if($proposal->tender->type == "SWASTA"){
                            $data['tender_detail_id'] = 2;
                        }
                    }
                } else {
                    echo 'tiada';
                        $data['tender_detail_id'] = 0;
                    echo PHP_EOL;
                }

                $data['company_id'] = $company->id;
                $data['is_approved'] = 1;
                $data['status'] = 'approved';
                \App\Models\CompanyApproval::create($data);
            }
        }

        public function migrate_company_rejected(){
            echo "syarikat gagal : ";
            $companies = \App\Models\Company::query()
            ->where('is_approved', false)
            ->distinct()
            ->get();

            foreach($companies as $company){
                $data['tender_detail_id'] = 0;
                $data['company_id'] = $company->id;
                $data['is_approved'] = 0;
                $data['status'] = 'rejected';

                \App\Models\CompanyApproval::create($data);
            }
        }

        public function sambungsiri_swasta(){
            echo "syarikat lulus : ";
            echo \App\Models\Company::query()
            ->where('is_approved', true)
            ->get()
            ->count();
        }

        public function pdf_only(){
            echo "pdf only : ";
            echo \App\Models\TenderSubmission::query()
                                ->whereHas('user.company', fn($query) =>
                                    $query->where('is_approved', true)
                                )
                                ->where('is_pdf_cert_uploaded','=', true)
                                ->whereHas('video', fn($query) =>
                                    $query->where('is_ready', false)
                                )
                                ->count();
        }

        public function video_only(){
            echo "video only : ";
            echo \App\Models\TenderSubmission::query()
                                ->whereHas('video', fn($query) =>
                                    $query->where('is_ready', true)
                                )
                                ->whereHas('user.company', fn($query) =>
                                    $query->where('is_approved', true)
                                )
                                //->where('is_pdf_cert_uploaded','=', false)
                                ->count();
        }

        function add_company_id_to_proposal(){
            \App\Models\TenderSubmission::query()
            ->has('user.company')
            ->get()
            ->each( function($value, $key){

                echo "ProposalId " . $value->id . " has CompanyId = ";
                // company->id
                echo $value->user->company->id;
                echo PHP_EOL;
                $proposal = \App\Models\TenderSubmission::find($value->id);
                $proposal->company_id = $value->user->company->id;
                $proposal->save();
            });
        }

        function add_tender_detail_id_to_proposal(){
            \App\Models\TenderSubmission::query()
            ->has('tender')
            ->get()
            ->each( function($value, $key){

                echo "ProposalId " . $value->id . " has TenderType = ";
                // company->id
                echo $type = $value->tender->type;
                echo PHP_EOL;
                if($type == "SAMBUNG SIRI"){
                    $proposal = \App\Models\TenderSubmission::find($value->id);
                    $proposal->tender_detail_id = 1;
                    $proposal->save();
                }

                if($type == "SWASTA"){
                    $proposal = \App\Models\TenderSubmission::find($value->id);
                    $proposal->tender_detail_id = 2;
                    $proposal->save();
                }
            });
        }

        function delete_proposal_with_no_company(){
            \App\Models\TenderSubmission::query()
            ->doesntHave('user.company')
            //->with('user.company')

            ->get()
            ->each( function($value, $key){

                echo "ProposalId " . $value->id . " ";
                // // company->id
                // \App\Models\TenderSubmission::destroy($value->id);
                echo PHP_EOL;
            });
        }

        function add_tender_detail_id_to_tender(){
            \App\Models\Tender::query()
            ->get()
            ->each( function($value,$key) {
                echo "TenderID " . $value->id;
                // get Tender Type
                echo " with Type = " . $type = $value->type;
                echo PHP_EOL;

                if($type == "SAMBUNG SIRI"){
                    $tender = \App\Models\Tender::find($value->id);
                    $tender->tender_detail_id = 1;
                    $tender->save();
                }

                if($type == "SWASTA"){
                    $tender = \App\Models\Tender::find($value->id);
                    $tender->tender_detail_id = 2;
                    $tender->save();
                }
            });

        }

        function count_proposal(){
            // $proposal = TenderSubmission::with('tender.tender_detail')->find(2);
            // dd($proposal->tender->tender_detail->id);
            $applied = \App\Models\Company::query()
            ->select('id')
            ->where('user_id' , 4)
            ->has('tender_submissions')
            ->withCount([ 'tender_submissions' => function ($q) {
                    $q->where('tender_detail_id', 3);
                }])
            ->first();
           dd($applied);
        }

        function copy(){
            /*
            scp -r root@***:/var/www/ukk-backend/storage/app/public/streaming/886 /var/www/ukk-backend/storage/app/public/streaming/886
            scp -r root@***:/var/www/ukk-backend/storage/assets/886 /var/www/ukk-backend/storage/assets/886
            scp -r root@***:/var/www/ukk-backend/storage/app/public/proposals/886 /var/www/ukk-backend/storage/app/public/proposals/886
            */
        }

        function test_proposal(){
            $tenderSubmission = \App\Models\TenderSubmission::query()
            ->where('id',1819)
            ->where('company_id', 762)
            ->first();
            dd($tenderSubmission);
        }

        function encode(){

            // App\Jobs\ConvertVideoQueue
            // send failed job to onQueue('failed_jobs')
            // $this->dispatch(new ConvertVideoQueue($video));
            //$job = new \App\Jobs\ConvertVideoQueue;
            $video = \App\Models\Video::find(4);
            $job =  ( new \App\Jobs\ConvertVideoQueue($video) )->onQueue("encode")->onConnection('database'); // Dispatchable
            dispatch($job);
        }

        function tenderSubmission(){

            $proposals = \App\Models\TenderSubmission::query()
                        //->whereNotNull('tender_detail_id')
                        ->whereNull('tender_detail_id')
                        ->with('tender_detail')

                        ->get();

            $proposals->each( function($val, $key) {
                echo $val->id . PHP_EOL;

                //echo $val->tender_detail->title . PHP_EOL;
                });
                echo "##################" . PHP_EOL;
                echo $proposals->count();

        }

        function add_user_id_to_tender_submissions_table(){
            // list all proposals without user_id
            $query = \App\Models\TenderSubmission::query()
            ->whereNull('user_id')
            ->has('company')
            ->get();

            $query->each( function($value, $key){

                #echo "userid :" . $user_id = $value->company->user->id . PHP_EOL;

                #echo $value->id . PHP_EOL;
                $ts =  \App\Models\TenderSubmission::find($value->id);

                // echo "Proposal ID : " . $ts->id . PHP_EOL;
                $ts->user_id = $value->company->user->id;
                if( $ts->save() ){
                    echo "Proposal id: ".$ts->id. " updated with user id: ". $ts->user_id . PHP_EOL;
                }
            });


            // unset($query);
            // // empty user_id but not with company->id
            // $query = \App\Models\TenderSubmission::query()
            // ->whereNull('user_id')
            // //->has('company')
            // ->get();
            // echo $query->count();
        }

        function add_tender_id(){
            // list tender_submission_id from scorings
            $query = \App\Models\Scoring::query()
                    ->has('tender')
                    ->orderBy('id','ASC')
                    ->get();

            $query->each(function($value,$key){

                echo "Scoring  ID-" . $value->id;
                echo " Proposal ID-" . $value->tender_submission_id;
                echo "  Tender ID-" . $value->tender_id . PHP_EOL;

                    // update
                    $proposal = \App\Models\TenderSubmission::find($value->tender_submission_id);
                    if($proposal){
                        $proposal->tender_id =  $value->tender->id ;

                       if($proposal->save()) {
                        echo "saved" . PHP_EOL;
                       }
                    }

            });



           // echo $query->count();
        }

        function empty_proposal(){
            \App\Models\TenderSubmission::query()
            ->whereNull('user_id')
            ->whereNull('tender_id')
            ->whereNull('tender_detail_id')
            ->whereNull('company_id')
            //->has('signers')
            ->get()
            ->each(function($value,$key){
                echo $value->id . PHP_EOL;
                echo $value->created_at . PHP_EOL;
            });
        }

        function proposal_new(){
            // date start = 2022-06-21
            $result = \App\Models\Video::query()
            ->whereBetween('created_at', ['2022-06-21', now() ])
            ->whereHas('tender_submission.tender.tender_detail', fn($query) =>
                $query->whereIn('id', [3,4])
            )
            ->get()
            ->count();

            echo $result;
        }


}// class
