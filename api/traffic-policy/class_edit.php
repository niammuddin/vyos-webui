<?php
include '../../functions.php';

if (isset($_POST['action'])) {

    $classId = $_POST['classId'];
    $shaperName = $_POST['shaperName'];
    // $match = $_POST['match'];
    $bandwidth = !empty($_POST['bandwidth']) ? $_POST['bandwidth'] : '15mbit';
    $burst = !empty($_POST['burst']) ? $_POST['burst'] : '15k';
    $queueType = !empty($_POST['queueType']) ? $_POST['queueType'] : 'fq-codel';
    $description = $_POST['description'];

    $url = routerIP().'/configure';
    $base_path = array('traffic-policy', 'shaper', $shaperName, 'class', $classId);
    $data = [
        [
            'op' => 'set',
            'path' => array_merge($base_path, ['bandwidth', $bandwidth])
        ],
        [
            'op' => 'set',
            'path' => array_merge($base_path, ['burst', $burst])
        ],
        // [
        //     'op' => 'set',
        //     'path' => array_merge($base_path, ['match', $match])
        // ],
        [
            'op' => 'set',
            'path' => array_merge($base_path, ['queue-type', $queueType])
        ],
        [
            'op' => 'set',
            'path' => array_merge($base_path, ['description', $description])
        ],
    ];

    $jsonData = getAPI($url, $data);
    $response = json_decode($jsonData, true);


    if (isset($response['success']) && $response['success'] === true) {

        $responseData = array(
            "success" => true,
            "error" => $response['error'],
            "data" => $response['data']
        );
    } else {

        $responseData = array(
            "success" => false,
            "error" => $response['error'],
            "data" => $response['data']
        );
    }
} else {

    $responseData = array(
        "success" => false,
        "error" => null,
        "data" => 'access denied'
    );
}

echo json_encode($responseData);