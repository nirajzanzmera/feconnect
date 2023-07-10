<?php
session_start();

if (isset($arg[1])) {
	$url=$arg[1];
} else {

}


function getRequest() {
    // open connection
    $ch = curl_init();
    
    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    //execute post
    $result = curl_exec($ch);
    
    //close connection
    curl_close($ch);
    
    return $result;
}

function postRequest() {
    if ($arr) {
        $params = http_build_query($arr);
    } else {
        $params = '';
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


?>