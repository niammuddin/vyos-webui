<?php
include '../../functions.php';
$url = routerIP().'/retrieve';

$policy = array(
    'op' => 'showConfig',
    'path' => array('traffic-policy')
);

$jsonData = getAPI($url, $policy);

$data = json_decode($jsonData, true);


$shaperName = $_POST['shaperName'];


if (isset($data['data']['shaper'][$shaperName]['class'])) {
    $classData = $data['data']['shaper'][$shaperName]['class'];
} else {
    $classData = array(); 
}


$jsonResponse = json_encode($classData);


header('Content-Type: application/json');
echo $jsonResponse;