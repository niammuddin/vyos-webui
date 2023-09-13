<?php
include '../../functions.php';

if (isset($_POST['action'])) {

    $shaperName = $_POST['shaperName'];
    $bandwidth = $_POST['bandwidth'];
    $defaultBandwidth = !empty($_POST['defaultBandwidth']) ? $_POST['defaultBandwidth'] : '100%';
    $defaultBurst = !empty($_POST['defaultBurst']) ? $_POST['defaultBurst'] : '15k';
    $defaultQueueType = !empty($_POST['defaultQueueType']) ? $_POST['defaultQueueType'] : 'fq-codel';
    $description = $_POST['description']; // kosong tidak masalah

    $url = routerIP().'/configure';
    $base_path = array('traffic-policy', 'shaper', $shaperName);
    $data = [
        [
            'op' => 'set',
            'path' => array_merge($base_path, ['bandwidth', $bandwidth])
        ],
        [
            'op' => 'set',
            'path' => array_merge($base_path, ['default', 'bandwidth', $defaultBandwidth])
        ],
        [
            'op' => 'set',
            'path' => array_merge($base_path, ['default', 'burst', $defaultBurst])
        ],
        [
            'op' => 'set',
            'path' => array_merge($base_path, ['default', 'queue-type', $defaultQueueType])
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
        "error" => true,
        "data" => 'access denied'
    );
}


echo json_encode($responseData);