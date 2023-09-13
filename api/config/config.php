<?php
include '../../functions.php';

if($_POST['action'] == 'get-config'){

$url = routerIP().'/retrieve';
$data = array(
    'op' => 'showConfig',
    'path' => []
);
$jsonData = getAPI($url, $data);
// $data = json_decode($jsonData, true);
echo $jsonData;
}

else{

    echo json_encode(
        [
        'success' => false,
        'message' => 'access denied'
        ]
    );

}
