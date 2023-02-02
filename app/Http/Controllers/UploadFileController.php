<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use function storage_path;

class UploadFileController extends Controller {

    public function uploadFile(Request $request) {
        //
        //dd($request);

        $request->validate(
            ['formFile' => 'required|mimes:application/xml,xml'],
            [
                'formFile.required' => 'A fejl megadása kötelező',
                'formFile.mimes' => 'Csak xml fájl tölthető fel'
            ]
        );

        $fileModel = new File;

        //dd($request->file('formFile')->getClientOriginalName());

        if ($request->file()) {

            $fileName = time() . '_' . $request->file('formFile')->getClientOriginalName();
            //$filePath = $request->file('formFile')->storeAs('uploads', $fileName, 'public');
            $filePath = $request->file('formFile')->storeAs('uploads', $fileName);

            //dd($filePath, $fileName);
            $fileModel->name = $fileName;
            //$fileModel->file_path = '/storage/' . $filePath;
            $fileModel->file_path = $filePath;
            //dd($fileModel->file_path, $fileModel->name);
            $fileModel->save();

            $res = $this->parseXml($fileModel);

            //dd($res);

            $eredmeny = "success";
            $uzenet = "Sikeres feltöltés";
            
            if( count($res['errors']) > 0 ){
                $eredmeny = "error";
                $uzenet = "Hib a feltöltéskor";
            }
            
            return back()
                    ->with($eredmeny, $uzenet)
                    ->with('fileName', $fileName)
                    ->with('res', $res);
        }
    }

    public function parseXml(File $fileModel) {

        // Feldolgozás eredménye
        $res = [
            'errors' => [], 
            'success' => []
        ];

        // XML feldolgozás
        $path = storage_path('app/' . $fileModel->file_path);
        $xmlObject = simplexml_load_file($path);
        $jsonFormatData = json_encode($xmlObject);
        $result = json_decode($jsonFormatData, true);

        // Szabályok
        $rules = [
            'ado_azonosito' => 'required|unique:persons,ado_azonosito',
            'egyeb_id' => 'required|unique:persons,egyeb_id',
            'email_cim' => 'required|unique:persons,email_cim',
        ];
        
        // Üzenetek
        $messages = [
            'ado_azonosito.required' => 'Az "ado_azonosito" megadása kötelező',
            'ado_azonosito.unique' => 'Az "ado_azonosito" már használatban',
            'egyeb_id.required' => 'Az "egyeb_azonosito" megadása kötelező',
            'egyeb_id.unique' => 'Az "egyeb_azonosito" már használatban',
            'email_cim.required' => 'Az "email_cim" megadása kötelező',
            'email_cim.unique' => 'Az "email_cim" már használatban',
        ];
        
        // XML -ből származó adatok feldolgozása
        foreach( $result['person'] as $person ){
            // Adatok ellenőrzése
            $validation = Validator::make($person, $rules, $messages);
            
            // Ha nincs hiba
            if( !$validation->fails() ){
                // Adatok mentése
                $p = \App\Models\Person::create($person);
                
                $eredmeny = 'JÓ';
                $cel = 'success';
                
                // Ha nem sikerült a mentés
                if( !$p ){
                    $eredmeny = 'ROSSZ';
                    $cel = 'errors';
                }
                
                array_push(
                    $res[$cel], 
                    [
                        'nev' => $person['teljes_nev'], 
                        'eredmeny' => $eredmeny
                    ]
                );
                
            }else{
                // Valami hiba van.
                array_push(
                    $res['errors'], 
                    [
                        'nev' => $person['teljes_nev'], 
                        'eredmeny' => 'ROSSZ', 
                        'messages' => $validation->errors()
                    ]
                );
            }
        }
        
        return $res;
    }

}
