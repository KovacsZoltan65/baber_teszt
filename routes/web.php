<?php

use Illuminate\Support\Facades\Route;
use App\Models\Person;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/read_xml', function(){

    $xml_filename = 'xml\baber.xml';
    /*
    dd(
        $xml_filename,
        public_path($xml_filename)
    );
    */
    echo '<pre>';
    $path = resource_path($xml_filename);
    //print_r($path);
    //$xmlFile = file_get_contents($path);
    //print_r($xmlFile);
    //$xmlObject = new SimpleXMLElement($path);
    $xmlObject = simplexml_load_file($path);
    //var_dump($xmlObject);
    //var_dump($xmlObject);
    $jsonFormatData = json_encode($xmlObject);
    $result = json_decode($jsonFormatData, true);
    //print_r($result['user'][0]);
    
    foreach( $result['user'] as $user ){
        //print_r($user);
        $person = Person::create( $user );
    }
    
    //$person = Person::create( $result['user'][0] );
    //print_r($person);
    
    print_r('VÉGE');
    echo '</pre>';
    
});
