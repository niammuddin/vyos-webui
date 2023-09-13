<?php
include '../../functions.php';

// get vlan interfaces
if (isset($_POST['action']) && $_POST['action'] == 'vlan-table') {
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
                $outputList[] = array(
                    'vlanId' => $vifId,
                    'iface' => $iface,
                    'ifaceType' => $ifaceType,
                    'redirect' => isset($vifData['redirect']) ? $vifData['redirect'] : '',
                    'description' => isset($vifData['description']) ? $vifData['description'] : ''
                );
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

// get vlan address
elseif(isset($_POST['action']) && $_POST['action'] == 'address-table') {
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
                        if (isset($vifData['address'])) {
                            if (is_array($vifData['address'])) {
                                foreach ($vifData['address'] as $address) {
                                    $outputList[] = array(
                                        'address' => $address,
                                        'vif' => $vifId,
                                        'iface' => $key,
                                        'ifaceType' => $ifaceType
                                    );
                                }
                            } else {
                                $outputList[] = array(
                                    'address' => $vifData['address'],
                                    'vif' => $vifId,
                                    'iface' => $key,
                                    'ifaceType' => $ifaceType
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

elseif(isset($_POST['action']) && $_POST['action'] == 'addVlanAddress') {
    $vif = $_POST['vlanId'];
    $ifaceType = $_POST['ifaceType'];
    $iface = $_POST['iface'];
    $address = $_POST['address'];

    $url = routerIP().'/configure';
    $base_path = ['interfaces', $ifaceType, $iface, 'vif', $vif];

    $data = [
        [
            'op' => 'set',
            'path' => array_merge($base_path, ['address', $address])
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

elseif(isset($_POST['action']) && $_POST['action'] == 'editVlanAddress') {

    $oldAddress = $_POST['oldAddress'];
    $ifaceType = $_POST['ifaceType'];
    $iface = $_POST['iface'];
    $vlanId = $_POST['vlanId'];
    $newAddress = $_POST['newAddress'];

    $url = routerIP().'/configure';
    $data = [
        [
            'op' => 'delete',
            'path' => ['interfaces', $ifaceType, $iface, 'vif', $vlanId, 'address', $oldAddress]
        ],
        [
            'op' => 'set',
            'path' => ['interfaces', $ifaceType, $iface, 'vif', $vlanId, 'address', $newAddress]
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

elseif(isset($_POST['action']) && $_POST['action'] == 'deleteVlanAddress') {

    $vlanId = $_POST['vlanId'];
    $iface = $_POST['iface'];
    $ifaceType = $_POST['ifaceType'];
    $address = $_POST['address'];

    $url = routerIP().'/configure';
    $data = [
        [
            'op' => 'delete',
            'path' => ['interfaces', $ifaceType, $iface, 'vif', $vlanId, 'address', $address]
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

elseif(isset($_POST['action']) && $_POST['action'] == 'add-traffic-policy') {

    $vlanId = $_POST['vlanId'];
    $ifaceType = $_POST['ifaceType'];
    $iface = $_POST['iface'];
    $trafficPolicyIn = $_POST['trafficPolicyIn'];
    $trafficPolicyOut = $_POST['trafficPolicyOut'];

    $url = routerIP().'/configure';
    $base_path = ['interfaces', $ifaceType, $iface, 'vif', $vlanId];


    $data = [];

   if (!empty($trafficPolicyIn)) {
        $data[] = [
            'op' => 'set',
            'path' => array_merge($base_path, ['traffic-policy', 'in', $trafficPolicyIn])
        ];
    }
   if (!empty($trafficPolicyOut)) {
        $data[] = [
            'op' => 'set',
            'path' => array_merge($base_path, ['traffic-policy', 'out', $trafficPolicyOut])
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

elseif(isset($_POST['action']) && $_POST['action'] == 'delete-traffic-policy') {

    $vlanId = $_POST['vlanId'];
    $iface = $_POST['iface'];
    $ifaceType = $_POST['ifaceType'];
    $trafficPolicyIn = $_POST['trafficPolicyIn'];
    $trafficPolicyOut = $_POST['trafficPolicyOut'];

    $url = routerIP().'/configure';
    $base_path = ['interfaces', $ifaceType, $iface, 'vif', $vlanId];

    $data = [];

    if (!empty($trafficPolicyIn)) {
         $data[] = [
             'op' => 'delete',
             'path' => array_merge($base_path, ['traffic-policy', 'in', $trafficPolicyIn])
         ];
     }
    if (!empty($trafficPolicyOut)) {
         $data[] = [
             'op' => 'delete',
             'path' => array_merge($base_path, ['traffic-policy', 'out', $trafficPolicyOut])
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

// add redirect ifb
elseif(isset($_POST['action']) && $_POST['action'] == 'add-redirect') {

    $ifaceType = $_POST['ifaceType'];
    $iface = $_POST['iface'];
    $vlanId = $_POST['vlanId'];
    $ifb = $_POST['ifb'];

    $url = routerIP().'/configure';
    $urlRetrieve = routerIP().'/retrieve';

    $existsCheck = array(
        'op' => 'exists',
        'path' => array('interfaces', $ifaceType, $iface, 'vif', $vlanId, 'redirect')
    );


    $jsonData = getAPI($urlRetrieve, $existsCheck);
    $response = json_decode($jsonData, true);

    if ($response['data'] === true ) {
        $responseData = array(
            "success" => false,
            "message" => 'data already exists on VLAN '. $vlanId
        );
    } else {
        $data = [
            [
                'op' => 'set',
                'path' => ['interfaces', $ifaceType, $iface, 'vif', $vlanId, 'redirect', $ifb]
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
}

elseif(isset($_POST['action']) && $_POST['action'] == 'delete-redirect') {

    $vlanId = $_POST['vlanId'];
    $iface = $_POST['iface'];
    $ifaceType = $_POST['ifaceType'];
    $redirect = $_POST['redirect'];

    $url = routerIP().'/configure';
    $data = [
        [
            'op' => 'delete',
            'path' => ['interfaces', $ifaceType, $iface, 'vif', $vlanId, 'redirect', $redirect]
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