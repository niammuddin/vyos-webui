<?php
include '../../functions.php';
if ($_POST['action'] == 'address-family') {
    $url = routerIP().'/retrieve';
    $data = array(
        'op' => 'showConfig',
        'path' => array('protocols', 'bgp')
    );

    $jsonData = getAPI($url, $data);
    $data = json_decode($jsonData, true);

    $protocolData = [];

    foreach ($data['data']['bgp'] as $asn => $bgpData) {
        if (isset($bgpData['address-family']['ipv4-unicast']['network'])) {
            foreach ($bgpData['address-family']['ipv4-unicast']['network'] as $network => $details) {
                $protocolData[] = [
                    'asn' => $asn,
                    'address_family' => 'ipv4-unicast',
                    'network' => $network
                ];
            }
        }

        if (isset($bgpData['address-family']['ipv6-unicast']['network'])) {
            foreach ($bgpData['address-family']['ipv6-unicast']['network'] as $network => $details) {
                $protocolData[] = [
                    'asn' => $asn,
                    'address_family' => 'ipv6-unicast',
                    'network' => $network
                ];
            }
        }
    }
    $responseData = ['data' => $protocolData];
}
elseif ($_POST['action'] == 'parameters') {
    $url = routerIP().'/retrieve';
    $data = array(
    'op' => 'showConfig',
    'path' => array('protocols', 'bgp')
    );

    $jsonData = getAPI($url, $data);
    $data = json_decode($jsonData, true);

    $protocolData = [];

    foreach ($data['data']['bgp'] as $asn => $bgpData) {
    $bestpath = isset($bgpData['parameters']['bestpath']) ? json_encode($bgpData['parameters']['bestpath']) : [];
    $routerId = isset($bgpData['parameters']['router-id']) ? $bgpData['parameters']['router-id'] : '';

    $protocolData[] = [
        'asn' => $asn,
        'bestpath' => $bestpath,
        'router_id' => $routerId
    ];
    }
    $responseData = ['data' => $protocolData];
}
elseif ($_POST['action'] == 'neighbor') {

    $url = routerIP().'/retrieve';
    $data = array(
        'op' => 'showConfig',
        'path' => array('protocols', 'bgp')
    );
    
    $jsonData = getAPI($url, $data);
    
    // Data processing
    $decodedData = json_decode($jsonData, true);
    $bgpData = $decodedData["data"]["bgp"];
    
    // Prepare the data for DataTables
    $dataForDataTables = array();
    
    foreach ($bgpData as $bgpKey => $bgp) {
        foreach ($bgp["neighbor"] as $neighbor => $details) {
            $addressFamilies = array_keys($details["address-family"]);
            $numAF = count($addressFamilies);
            $afCounter = 0;
            foreach ($details["address-family"] as $af => $afDetails) {
                $dataForDataTables[] = array(
                    'bgpKey' => $bgpKey,
                    'neighborIP' => $neighbor,
                    'description' => $details["description"],
                    'remoteAs' => $details["remote-as"],
                    'addressFamily' => $af,
                    'routeMapExport' => $afDetails["route-map"]["export"],
                    'routeMapImport' => $afDetails["route-map"]["import"]
                );
                if (++$afCounter < $numAF) {
                    $dataForDataTables[] = array(
                        'bgpKey' => '',
                        'neighborIP' => '',
                        'description' => '',
                        'remoteAs' => '',
                        'addressFamily' => '',
                        'routeMapExport' => '',
                        'routeMapImport' => ''
                    );
                }
            }
        }
    }
    
    // Response preparation for DataTables
    $responseData = array(
        'draw' => intval($_POST['draw']),
        'recordsTotal' => count($dataForDataTables),
        'recordsFiltered' => count($dataForDataTables),
        'data' => $dataForDataTables
    );
    
}
elseif ($_POST['action'] == 'add-neighbor') {

    $bgpKey = $_POST['bgpKey'];
    $neighborIP = $_POST['neighborIP'];
    $description = $_POST['description'];
    $remoteAs = $_POST['remoteAs'];
    $addressFamily = $_POST['addressFamily'];
    $routeMapExport = $_POST['routeMapExport'];
    $routeMapImport = $_POST['routeMapImport'];

    $url = routerIP().'/configure';
    $base_path = array('protocols', 'bgp', $bgpKey, 'neighbor', $neighborIP);
    $data = [
        [
            'op' => 'set',
            'path' => array_merge($base_path, ['remote-as', $remoteAs])
        ],
        [
            'op' => 'set',
            'path' => array_merge($base_path, ['description', $description])
        ],
        [
            'op' => 'set',
            'path' => array_merge($base_path, ['address-family', $addressFamily, 'route-map', 'export', $routeMapExport])
        ],
        [
            'op' => 'set',
            'path' => array_merge($base_path, ['address-family', $addressFamily, 'route-map', 'import', $routeMapImport])
        ],
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
elseif ($_POST['action'] == 'edit-neighbor'){

    $bgpKey = $_POST['bgpKey'];
    $neighborIP = $_POST['neighborIP'];
    $description = $_POST['description'];
    $remoteAs = $_POST['remoteAs'];
    $addressFamily = $_POST['addressFamily'];
    $routeMapExport = $_POST['routeMapExport'];
    $routeMapImport = $_POST['routeMapImport'];

    $url = routerIP().'/configure';
    $base_path = array('protocols', 'bgp', $bgpKey, 'neighbor', $neighborIP);
    $data = [
        [
            'op' => 'set',
            'path' => array_merge($base_path, ['remote-as', $remoteAs])
        ],
        [
            'op' => 'set',
            'path' => array_merge($base_path, ['description', $description])
        ],
        [
            'op' => 'set',
            'path' => array_merge($base_path, ['address-family', $addressFamily, 'route-map', 'export', $routeMapExport])
        ],
        [
            'op' => 'set',
            'path' => array_merge($base_path, ['address-family', $addressFamily, 'route-map', 'import', $routeMapImport])
        ],
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
elseif ($_POST['action'] == 'delete-neighbor'){
    $bgpKey = $_POST['bgpKey'];
    $neighborIP = $_POST['neighborIP'];

    $url = routerIP().'/configure';
    $data = array(
        'op' => 'delete',
        'path' => array('protocols', 'bgp', $bgpKey, 'neighbor', $neighborIP)
    );

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
