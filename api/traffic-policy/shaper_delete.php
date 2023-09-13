<?php
include '../../functions.php';

if (isset($_POST['shaperName'])) {
    $shaperName = $_POST['shaperName'];

    $url = routerIP().'/configure';
    $data = [
        [
            'op' => 'delete',
            'path' => ['traffic-policy', 'shaper', $shaperName]
        ]
    ];


    $jsonData = getAPI($url, $data);
    $response = json_decode($jsonData, true);


    if (isset($response['success']) && $response['success'] === true) {

        $responseData = array(
            "success" => true,
            "message" => $response['data']
        );
    } else {

        $responseData = array(
            "success" => false,
            "message" => $response['error']
        );
    }
} else {

    $responseData = array(
        "success" => false,
        "message" => 'access denied'
    );
}

echo json_encode($responseData);