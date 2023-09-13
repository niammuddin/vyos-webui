<?php
include '../../functions.php';
$url = routerIP().'/retrieve';
$data = array(
    'op' => 'showConfig',
    'path' => []
);
$jsonData = getAPI($url, $data);
$data = json_decode($jsonData, true);
echo $jsonData;
