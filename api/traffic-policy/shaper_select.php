<?php
include '../../functions.php';
$url = routerIP().'/retrieve';

$policy = array(
    'op' => 'showConfig',
    'path' => array('traffic-policy')
);

$jsonData = getAPI($url, $policy);


$data = json_decode($jsonData, true);


if (isset($data['data']['shaper'])) {
    $shaperData = $data['data']['shaper'];
} else {
    $shaperData = array();
}


$jsonResponse = json_encode($shaperData);


header('Content-Type: application/json');
echo $jsonResponse;