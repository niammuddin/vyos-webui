<?php
include '../../functions.php';
$url = routerIP().'/retrieve';
$data = array(
    'op' => 'showConfig',
    'path' => array('traffic-policy')
);
$jsonData = getAPI($url, $data);

$data = json_decode($jsonData, true);
$shaper_data = $data['data']['shaper'];

$result = array();
foreach ($shaper_data as $shaper_name => $shaper_details) {
    $result[] = $shaper_name;
}

header('Content-Type: application/json');
echo json_encode($result);
