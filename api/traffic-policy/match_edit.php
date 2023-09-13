<?php
include '../../functions.php';

if (isset($_POST['action'])) {
    
    $shaperName = $_POST['shaperName'];
    $classId = $_POST['classId'];
    $match = $_POST['match'];
    $interface = $_POST['interface'];
    $dstIP = $_POST['dstIP'];
    $srcIP = $_POST['srcIP'];
    $description = $_POST['description'];

    $url = routerIP().'/configure';
    $base_path = array('traffic-policy', 'shaper', $shaperName, 'class', $classId, 'match', $match);
    $data = [];


    if (!empty($dstIP)) {
        $data[] = [
            'op' => 'set',
            'path' => array_merge($base_path, ['ip', 'destination', 'address', $dstIP])
        ];
    }

    if (!empty($srcIP)) {
        $data[] = [
            'op' => 'set',
            'path' => array_merge($base_path, ['ip', 'source', 'address', $srcIP])
        ];
    }

    if (!empty($interface)) {
        $data[] = [
            'op' => 'set',
            'path' => array_merge($base_path, ['interface', $interface])
        ];
    }

    if (!empty($description)) {
        $data[] = [
            'op' => 'set',
            'path' => array_merge($base_path, ['description', $description])
        ];
    }

    $jsonData = getAPI($url, $data);
    $response = json_decode($jsonData, true);

    if (isset($response['success']) && $response['success'] === true) {
        $responseData = array(
            "success" => true,
            "message" => 'Match '.$match.' has been Edit.'
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