<?php

function compressImage($image){
    require_once("vendor/autoload.php");
    $apiKey = getenv("TINYPING_KEY");
    \Tinify\setKey($apiKey);
    $source = \Tinify\fromFile($image['file']);
    $source->toFile($image['file']);
}