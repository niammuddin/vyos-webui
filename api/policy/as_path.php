<?php
include '../../functions.php';

// get vlan interfaces
if ($_POST['action'] == 'as-path-list') {
    $url = routerIP().'/retrieve';
    $data = array(
        'op' => 'showConfig',
        'path' => array('policy')
    );

    $jsonData = getAPI($url, $data);
    $data = json_decode($jsonData, true);

    if ($data && isset($data['data']['as-path-list'])) {
        $formattedData = array();
        $asPathList = $data['data']['as-path-list'];
    
        foreach ($asPathList as $listName => $listData) {
            $formattedData[] = array(
                'aspath_name' => $listName,
                'description' => isset($listData['description']) ? $listData['description'] : ''
            );
        }
    $responseData = array('data' => $formattedData);
    }

}


elseif($_POST['action'] == 'rule-table') {
    $url = routerIP().'/retrieve';
    $data = array(
        'op' => 'showConfig',
        'path' => array('policy')
    );

    $jsonData = getAPI($url, $data);
    $data = json_decode($jsonData, true);

    if (isset($data['data']['as-path-list'])) {
        $formattedData = array();
        $asPathList = $data['data']['as-path-list'];

        foreach ($asPathList as $listName => $listData) {
            if (isset($listData['rule'])) {
                foreach ($listData['rule'] as $ruleNumber => $rule) {
                    $formattedData[] = array(
                        'listName' => $listName,
                        'ruleNumber' => $ruleNumber,
                        'action' => isset($rule['action']) ? $rule['action'] : '',
                        'regex' => isset($rule['regex']) ? $rule['regex'] : '',
                        'description' => isset($rule['description']) ? $rule['description'] : ''
                    );
                }
            }
        }
    $responseData = array('data' => $formattedData);
    }
}

elseif(isset($_POST['action']) && $_POST['action'] == 'traffic-policy-table') {
    $url = routerIP().'/retrieve';
    $data = array(
        'op' => 'showConfig',
        'path' => array('interfaces')
    );
    
    $jsonData = getAPI($url, $data);
    
    // Decode JSON data into a PHP array
    $data = json_decode($jsonData, true);
    
    // Function to format data for DataTables
    function formatData($array, &$outputList, $iface = null, $ifaceType = null) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (isset($value['vif'])) {
                    foreach ($value['vif'] as $vifId => $vifData) {
                        if (isset($vifData['traffic-policy']['in']) || isset($vifData['traffic-policy']['out'])) {
                            if (is_array($vifData['address'])) {
                                foreach ($vifData['address'] as $address) {
                                    $outputList[] = array(
                                        'vlanId' => $vifId,
                                        'iface' => $key,
                                        'ifaceType' => $ifaceType,
                                        'trafficPolicyIn' => isset($vifData['traffic-policy']['in']) ? $vifData['traffic-policy']['in'] : '',
                                        'trafficPolicyOut' => isset($vifData['traffic-policy']['out']) ? $vifData['traffic-policy']['out'] : ''
                                    );
                                }
                            } else {
                                $outputList[] = array(
                                    'vlanId' => $vifId,
                                    'iface' => $key,
                                    'ifaceType' => $ifaceType,
                                    'trafficPolicyIn' => isset($vifData['traffic-policy']['in']) ? $vifData['traffic-policy']['in'] : '',
                                    'trafficPolicyOut' => isset($vifData['traffic-policy']['out']) ? $vifData['traffic-policy']['out'] : ''
                                );
                            }
                        }
                    }
                }
                formatData($value, $outputList, $key, $key);
            }
        }
    }
    
    $outputList = array();
    formatData($data['data'], $outputList);
    $responseData = array('data' => $outputList);
}

elseif (isset($_POST['action']) && $_POST['action'] == 'redirect-table') {
    $url = routerIP().'/retrieve';
    $data = array(
        'op' => 'showConfig',
        'path' => array('interfaces')
    );
    
    $jsonData = getAPI($url, $data);
    
    $data = json_decode($jsonData, true);
    
    function formatData($array, &$outputList, $iface = null, $ifaceType = null) {
        foreach ($array as $key => $value) {
            if ($key === "vif") {
                foreach ($value as $vifId => $vifData) {
                    if (isset($vifData['redirect']) && strpos($vifData['redirect'], 'ifb') !== false) {
                        $outputList[] = array(
                            'ifaceType' => $ifaceType,
                            'iface' => $iface,
                            'vlanId' => $vifId,
                            'redirect' => $vifData['redirect']
                        );
                    }
                }
            } elseif ($key === "interface") {
                // Skip processing interfaces, as we don't want to include them in the output list
                continue;
            } elseif (is_array($value)) {
                formatData($value, $outputList, $key, $iface);
            }
        }
    }
    $outputList = array();
    formatData($data, $outputList);
    $responseData = array('data' => $outputList);
}

// add vlan
elseif(isset($_POST['action']) && $_POST['action'] == 'addVlan') {

    $vif = $_POST['vlanId'];
    $ifaceType = $_POST['ifaceType'];
    $iface = $_POST['iface'];
    $description = $_POST['description'];
    $url = routerIP().'/configure';
    $base_path = ['interfaces', $ifaceType, $iface];

    $data = [
        [
            'op' => 'set',
            'path' => array_merge($base_path, ['vif', $vif])
        ],
        [
            'op' => 'set',
            'path' => array_merge($base_path, ['vif', $vif, 'description', $description])
        ]
    ];
    
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

// edit vlan
elseif(isset($_POST['action']) && $_POST['action'] == 'editVlan') {

    $vlanId = $_POST['vlanId'];
    $iface = $_POST['iface'];
    $ifaceType = $_POST['ifaceType'];
    $address = $_POST['address'];
    $description = $_POST['description']; // kosong tidak masalah

    $url = routerIP().'/configure';
    $base_path = array('interfaces', $ifaceType, $iface, 'vif', $vlanId);

    $data = [];
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
            "message" => $response['data']
        );
    } else {
        $responseData = array(
            "success" => false,
            "message" => $response['error']
        );
    }

}

// vlan delete
elseif(isset($_POST['action']) && $_POST['action'] == 'deleteVlan') {

    $vlanId = $_POST['vlanId'];
    $iface = $_POST['iface'];
    $ifaceType = $_POST['ifaceType'];

    $url = routerIP().'/configure';
    $data = [
        [
            'op' => 'delete',
            'path' => ['interfaces', $ifaceType, $iface, 'vif', $vlanId]
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
}

else {
    $responseData = array(
        "success" => false,
        "message" => 'access denied'
    );
}
echo json_encode($responseData);