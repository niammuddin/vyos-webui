<?php
include '../../functions.php';

if ($_POST['action'] == 'ifb-table') {
$url = routerIP().'/retrieve';
$data = array(
    'op' => 'showConfig',
    'path' => array('interfaces')
);

$jsonData = getAPI($url, $data);

$data = json_decode($jsonData, true);
$input = $data['data']['input'];
$output = [];

foreach ($input as $interfaceName => $interfaceData) {
    $output[] = [
        'ifb' => $interfaceName,
        'description' => isset($interfaceData['description']) ? $interfaceData['description'] : ''
    ];
}

$responseData = array(
    'draw' => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
    'recordsTotal' => count($output),
    'recordsFiltered' => count($output),
    'data' => $output
);

// traffic-policy
} elseif ($_POST['action'] == 'traffic-policy-table') {
    $url = routerIP().'/retrieve';
    $data = array(
        'op' => 'showConfig',
        'path' => array('interfaces')
    );
    
    $jsonData = getAPI($url, $data);
    $data = json_decode($jsonData, true);
    $input = $data['data']['input'];
    $output = [];
    foreach ($input as $ifbName => $ifbData) {
        if (isset($ifbData['traffic-policy']['in']) || isset($ifbData['traffic-policy']['out'])) {
        $inPolicy = isset($ifbData['traffic-policy']['in']) ? $ifbData['traffic-policy']['in'] : '';
        $outPolicy = isset($ifbData['traffic-policy']['out']) ? $ifbData['traffic-policy']['out'] : '';
    
        $output[] = array(
            'ifb' => $ifbName,
            'trafficPolicyIn' => $inPolicy,
            'trafficPolicyOut' => $outPolicy
        );
    }
    }
    
    $responseData = array(
        'draw' => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
        'recordsTotal' => count($output),
        'recordsFiltered' => count($output),
        'data' => $output
    );

}

elseif($_POST['action'] == 'add-ifb') {

    $ifb = $_POST['ifb'];
    $description = $_POST['description'];
    $url = routerIP().'/configure';

    $data = [];

    if(!empty($ifb)){
        $data[] = [
            'op' => 'set',
            'path' => ['interfaces', 'input', $ifb]
        ];
    }

    if(!empty($description)){
        $data[] = [
            'op' => 'set',
            'path' => ['interfaces', 'input', $ifb , 'description', $description]
        ];
    }
    
    $jsonData = getAPI($url, $data);
    $response = json_decode($jsonData, true);

    if ($response['success'] === true) {

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
}

elseif($_POST['action'] == 'delete-ifb') {

    $ifb = $_POST['ifb'];
    $url = routerIP().'/configure';

    $data = [];

    if(!empty($ifb)){
        $data[] = [
            'op' => 'delete',
            'path' => ['interfaces', 'input', $ifb]
        ];
    }

    $jsonData = getAPI($url, $data);
    $response = json_decode($jsonData, true);

    if ($response['success'] === true) {

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
}

elseif($_POST['action'] == 'edit-ifb') {

    $ifb = $_POST['ifb'];
    $description = $_POST['description'];
    $url = routerIP().'/configure';

    $data = [];

    if(!empty($description)){
        $data[] = [
            'op' => 'set',
            'path' => ['interfaces', 'input', $ifb , 'description', $description]
        ];
    }
    
    $jsonData = getAPI($url, $data);
    $response = json_decode($jsonData, true);

    if ($response['success'] === true) {

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
}



elseif($_POST['action'] == 'add-traffic-policy') {

    $ifb = $_POST['ifb'];
    $trafficPolicyIn = $_POST['trafficPolicyIn'];
    $trafficPolicyOut = $_POST['trafficPolicyOut'];
    $url = routerIP().'/configure';

    // interfaces input ifb0 traffic-policy out
    $data = [];

    if(!empty($trafficPolicyIn)){
        $data[] = [
            'op' => 'set',
            'path' => ['interfaces', 'input', $ifb , 'traffic-policy', 'in', $trafficPolicyIn]
        ];
    }
    if(!empty($trafficPolicyOut)){
        $data[] = [
            'op' => 'set',
            'path' => ['interfaces', 'input', $ifb , 'traffic-policy', 'out', $trafficPolicyOut]
        ];
    }
    
    $jsonData = getAPI($url, $data);
    $response = json_decode($jsonData, true);

    if ($response['success'] === true) {

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
}
elseif($_POST['action'] == 'delete-traffic-policy') {

    $ifb = $_POST['ifb'];
    $trafficPolicyIn = $_POST['trafficPolicyIn'];
    $trafficPolicyOut = $_POST['trafficPolicyOut'];
    $url = routerIP().'/configure';

    $data = [];

    if(!empty($trafficPolicyIn)){
        $data[] = [
            'op' => 'delete',
            'path' => ['interfaces', 'input', $ifb , 'traffic-policy', 'in', $trafficPolicyIn]
        ];
    }

    if(!empty($trafficPolicyOut)){
        $data[] = [
            'op' => 'delete',
            'path' => ['interfaces', 'input', $ifb , 'traffic-policy', 'out', $trafficPolicyOut]
        ];
    }

    $jsonData = getAPI($url, $data);
    $response = json_decode($jsonData, true);

    if ($response['success'] === true) {

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
}

else {
    $responseData = array(
        "success" => false,
        "message" => 'access denied'
    );
}
echo json_encode($responseData);