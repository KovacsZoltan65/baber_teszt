<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class XmlController extends BaseController{

    function read_xml(string $file_name){
        //
        $xmlFile = file_get_contents(public_path('babel.xml'));
        $xmlObject = simplexml_load_file($xmlFile);
        $jsonFormatData = json_encode($xmlObject);
        $result = json_decode($jsonFormatData, true);

        dd($result);
    }
}