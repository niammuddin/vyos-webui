<?php
include '../../functions.php';

if (isset($_POST['action'])) {

    $shaperName = $_POST['shaperName'];
    $classId = $_POST['classId'];
    $match = $_POST['match'];

    $url = routerIP().'/configure';
    $data = [
        [
            'op' => 'delete',
            'path' => ['traffic-policy', 'shaper', $shaperName, 'class', $classId, 'match', $match]
        ]
    ];


    $jsonData = getAPI($url, $data);
    $response = json_decode($jsonData, true);


    if (isset($response['success']) && $response['success'] === true) {

        $responseData = array(
            "success" => true
        );
    } else {

        $responseData = array(
            "success" => false
        );
    }
} else {

    $responseData = array(
        "success" => false
    );
}


echo json_encode($responseData);