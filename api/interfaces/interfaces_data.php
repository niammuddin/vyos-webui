<?php
include '../../functions.php';

if (isset($_POST['action']) && $_POST['action'] == 'interfaces-data') {

$url = routerIP().'/retrieve';

$data = array(
    'op' => 'showConfig',
    'path' => array('interfaces')
);

$jsonData = getAPI($url, $data);

// $data = json_decode($jsonData, true);

echo $jsonData;

} else {
    $responseData = array(
        "success" => false,
        "message" => 'access denied'
    );
    echo json_encode($responseData);
}



