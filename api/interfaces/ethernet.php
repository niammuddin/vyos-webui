<?php
include '../../functions.php';

if (isset($_POST['action']) && $_POST['action'] == 'ethernet-table') {

$url = routerIP().'/retrieve';
$data = array(
    'op' => 'showConfig',
    'path' => array('interfaces')
);
$jsonData = getAPI($url, $data);
$data = json_decode($jsonData, true);
$ethernet_data = $data['data']['ethernet'];
$datatable_data = array();
foreach ($ethernet_data as $ethernet_name => $ethernet_details) {


    // Calculate the number of vif entries
    $num_vif = isset($ethernet_details['vif']) ? count($ethernet_details['vif']) : 0;
    $ethernet_desc = isset($ethernet_details['description']) ? $ethernet_details['description'] : 'N/A';
    $ethernet_mac = isset($ethernet_details['hw-id']) ? $ethernet_details['hw-id'] : 'N/A';

    $row = array(
        "ethernetName" => $ethernet_name,
        "description" => $ethernet_desc,
        "ethernet_mac" => $ethernet_mac,
        "numvif" => $num_vif
    );

    $datatable_data[] = $row;
}
$responseData = array(
    'draw' => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
    'recordsTotal' => count($datatable_data),
    'recordsFiltered' => count($datatable_data),
    'data' => $datatable_data
);
}

// ethernet address
elseif (isset($_POST['action']) && $_POST['action'] == 'address-table') {

    $url = routerIP().'/retrieve';
    $data = array(
        'op' => 'showConfig',
        'path' => array('interfaces')
    );
    $jsonData = getAPI($url, $data);

    $json = json_decode($jsonData, true);
    $output = array();
    
    foreach ($json['data']['ethernet'] as $ethernetInterface => $ethernetData) {
        $addresses = isset($ethernetData['address']) ? (array)$ethernetData['address'] : [];
        foreach ($addresses as $address) {
            $output[] = array(
                "ethernetName" => $ethernetInterface,
                "address" => $address
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

// edit ethernet
elseif (isset($_POST['action']) && $_POST['action'] == 'edit-ethernet'){

    $ethernetName = $_POST['ethernetName'];
    $description = $_POST['description'];
    $base_path = ['interfaces', 'ethernet', $ethernetName];
    $url = routerIP().'/configure';

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
            "message" => $response['data']
        );
    }
}

// add ip address
elseif (isset($_POST['action']) && $_POST['action'] == 'add-ethernet-address') {

    $interfaceName = $_POST['ethernetName'];
    $address = $_POST['address'];
    $url = routerIP().'/configure';

    $data = array(
        'op' => 'set',
        'path' => array('interfaces', 'ethernet', $interfaceName, 'address', $address)
    );

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
            "message" => $response['data']
        );
    }
    
}

// delete address
elseif(isset($_POST['action']) && $_POST['action'] == 'delete-address') {

    
    $ethernetName = $_POST['ethernetName'];
    $address = $_POST['address'];

    $url = routerIP().'/configure';
    $data = [
        [
            'op' => 'delete',
            'path' => array('interfaces', 'ethernet', $ethernetName, 'address', $address)
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
            "message" => $response['data']
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
