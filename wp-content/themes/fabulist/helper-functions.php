<?php

function compressImage($image){
    require_once("vendor/autoload.php");
    $apiKey = getenv("TINYPING_KEY");
    \Tinify\setKey($apiKey);
    $source = \Tinify\fromFile($image['file']);
    $resized = $source->resize(array(
        "method" => "scale",
        "width" => 500
    ));
    
    $resized->toFile($image['file']);
}