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


function construct_caption_html($post) {
    $captionDate = caption_date($post->post_date);
    echo "<b>" . $captionDate . "</b>";
    echo "<br>";
    the_post_thumbnail_caption();
}

function caption_date($post_date) {
    if(!defined("SECONDS_IN_A_DAY")){define("SECONDS_IN_A_DAY", 86400);}
    if(!defined("SECONDS_IN_AN_HOUR")){define("SECONDS_IN_AN_HOUR", 3600);}
    if(!defined("SECONDS_IN_A_MINUTE")) {define("SECONDS_IN_A_MINUTE", 60);}
    if(!defined("SECONDS_IN_8_HOURS")) {define("SECONDS_IN_8_HOURS", SECONDS_IN_AN_HOUR * 8);}
    
    $date_time_post_epoch = strtotime(date('r', strtotime($post_date)));
    $date_time_now_epoch = strtotime(date('m/d/Y h:i:s a', time()));
    $midnight_of_today = strtotime("today") - SECONDS_IN_A_DAY;
    $difference_between_now_and_post = $date_time_now_epoch - $date_time_post_epoch;

    if($date_time_post_epoch < $midnight_of_today) {
        $elapsedTime = round(($date_time_now_epoch - $date_time_post_epoch)/SECONDS_IN_A_DAY);
        $typeOfMeasurement = "day";
    } else if($difference_between_now_and_post < SECONDS_IN_A_MINUTE) {
        $elapsedTime = round(($date_time_now_epoch - $date_time_post_epoch));
        $typeOfMeasurement = "second";
    } else if($difference_between_now_and_post < SECONDS_IN_AN_HOUR) {
        $elapsedTime = round(($date_time_now_epoch - $date_time_post_epoch)/SECONDS_IN_A_MINUTE);
        $typeOfMeasurement = "minute";
    } else if($difference_between_now_and_post > SECONDS_IN_AN_HOUR) {
        $elapsedTime =  round(($date_time_now_epoch - $date_time_post_epoch)/SECONDS_IN_AN_HOUR);
        $typeOfMeasurement = "hour";
    }

    if($elapsedTime == 1) {
        return "Posted ". $elapsedTime . " " . $typeOfMeasurement ." ago";
    } else {
        return "Posted ". $elapsedTime . " " . $typeOfMeasurement ."s ago";
    }
}


function getAuthTokenFromMicroservice() {
    $user = wp_get_current_user();
    if($user->ID == 0) {
        return null;
    }
    $url = MICROSERVICE_URL . "/user/create/token?secret=" . MICROSERVICE_SECRET . "&user_id=$user->ID";
    $response = wp_remote_post($url, null);
    if(is_wp_error($response)){
        return null;
    }
    return $response["body"];
}


function setAuthCookie() {
    if(!isset($_COOKIE['elsie_gram_auth'])) {
        $response = json_decode(getAuthTokenFromMicroservice());
        if($response) {
            if($_SERVER["SERVER_NAME"] == "localhost") {
                setcookie("elsie_gram_auth", $response->token, time() + (10 * 365 * 24 * 60 * 60), "/"); 
            }
            setcookie("elsie_gram_auth", $response->token, time() + (10 * 365 * 24 * 60 * 60), "/", ".elsiegram.com", 1, 1);
        }
    }
}

function addPostToMicroservice($postContent, $postImageUrl) {
    $url = MICROSERVICE_URL . "/post/add";
    $body = array(
        postContent => $postContent,
        postImageUrl => $postImageUrl
    );
    $cookies = array(
        new WP_Http_Cookie(array(
            'name' => 'elsie_gram_auth',
            'value' => $_COOKIE['elsie_gram_auth']
        ))
    );

    $args = Array(
        'headers' => Array(
            'Content-Type' => 'application/json'
        ),
        'body' => json_encode($body),
        'cookies' => $cookies
    );
    $response = wp_remote_post($url, $args);
    return $response;
}
function addUserToMicroservice($user) {
    $updatedUser = getUpdatedUser($user);
    $email = $updatedUser->data->user_email;
    $name = $updatedUser->data->user_login;
    $password = $updatedUser->data->user_pass;
    $id = $updatedUser->data->ID;
    $url = MICROSERVICE_URL . "/user/add?id=" . $id . "&email=" . $email. "&name=" . $name ."&password=" . urlencode($password) . "&secret=" . MICROSERVICE_SECRET;

    $args = Array();
    $response = wp_remote_post($url, $args);
    return $response;
}

function getUpdatedUser($user) {
    $user = get_user_by( 'email', $user->user_email );
    return $user;
}