<?php

use Illuminate\Support\Facades\App;

function getAssets(){
    if (file_get_contents(base_path()."/".config('app.public')."/build/manifest.json")){
        $json = json_decode(file_get_contents(base_path()."/".config('app.public')."/build/manifest.json"),true);
        return [
            "css" => $json['resources/js/app.js']['css'][0],
            "js" => $json['resources/js/app.js']['file']
        ];
    }
}

function getStates(){
    if(file_exists(base_path()."/states.json")){
        return json_decode(file_get_contents(base_path()."/states.json"));
    }
}
