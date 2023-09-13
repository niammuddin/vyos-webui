<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /login.php");
    exit;
}
function routerIP(){

    // YOUR_IP_ADDRESS
    return 'https://10.10.10.10';
}
function apiKey(){
    
    // YOUR_API_KEY
    return 'YOUR_API_KEY';
}

function getAPI($url, $data) {
    $curl = curl_init();
    $postData = array(
        'data' => json_encode($data),
        'key' => apiKey()
    );
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $postData
    ));
    $responses = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);
    if ($error) {
        return $error;
    } else {
        return $responses;
    }
}

function getColorForNextHop($nextHop, &$nextHopColors) {
    if (!isset($nextHopColors[$nextHop])) {
        $hash = crc32($nextHop);
        $color = substr(md5($hash), 0, 6);
        $nextHopColors[$nextHop] = $color;
    }
    return $nextHopColors[$nextHop];
}