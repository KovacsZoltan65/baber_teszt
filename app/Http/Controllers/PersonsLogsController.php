<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\PersonsLogs;

class PersonsLogsController extends Controller {

    public function index() {
        
        $persons = Person::get();
        //$persons = Person::take(10);
        
        $persons_logs = PersonsLogs::all();
        
        //dd($persons,$persons_logs);
        
        //echo '<pre>';
        //foreach( $persons as $person ){
        //    print_r($person->teljes_nev);
        //}
        //echo '</pre>';
/*
        $persons = [
            ['A' => 'a', 'B' => 'b', 'C' => 'c'],
            ['A' => 'a', 'B' => 'b', 'C' => 'c'],
            ['A' => 'a', 'B' => 'b', 'C' => 'c'],
            ['A' => 'a', 'B' => 'b', 'C' => 'c'],
        ];
        $logs = [
            ['A' => 'a', 'B' => 'b', 'C' => 'c'],
            ['A' => 'a', 'B' => 'b', 'C' => 'c'],
            ['A' => 'a', 'B' => 'b', 'C' => 'c'],
            ['A' => 'a', 'B' => 'b', 'C' => 'c'],
        ];
*/
        
        return \View::make('persons_logs',
                compact('persons', 'persons_logs')
        );
        
    }

}
