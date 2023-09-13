<?php
include '../../functions.php';

// read bonding-table
if (isset($_POST['action']) && $_POST['action'] == 'bonding-table') {
$url = routerIP().'/retrieve';
$data = array(
    'op' => 'showConfig',
    'path' => array('interfaces')
);
$jsonData = getAPI($url, $data);
$data = json_decode($jsonData, true);
$bonding_data = $data['data']['bonding'];
$datatable_data = array();
foreach ($bonding_data as $bond_name => $bond_details) {
    $member_interfaces = isset($bond_details['member']['interface']) ? (array)$bond_details['member']['interface'] : array();
    $member_interfaces_str = implode(', ', $member_interfaces);

    // Calculate the number of vif entries
    $num_vif = isset($bond_details['vif']) ? count($bond_details['vif']) : 0;

    $row = array(
        "interface" => $bond_name,
        "mode" => $bond_details['mode'],
        "hashpolicy" => $bond_details['hash-policy'],
        "memberinterface" => $member_interfaces_str,
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

// read address-table
elseif (isset($_POST['action']) && $_POST['action'] == 'address-table') {

    $url = routerIP().'/retrieve';
    $data = array(
        'op' => 'showConfig',
        'path' => array('interfaces')
    );
    $jsonData = getAPI($url, $data);

    $json = json_decode($jsonData, true);
    $output = array();
    
    foreach ($json['data']['bonding'] as $bondingInterface => $bondingData) {
        $addresses = isset($bondingData['address']) ? (array)$bondingData['address'] : [];
        foreach ($addresses as $address) {
            $output[] = array(
                "interface" => $bondingInterface,
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

// add bonding
elseif (isset($_POST['action']) && $_POST['action'] == 'add-bonding') {
    $bondName = $_POST['bondName'];
    $bondMode = $_POST['bondMode'];
    $hashPolicy = $_POST['hashPolicy'];
    $bondMember = $_POST['bondMember'];
    $base_path = ['interfaces', 'bonding', $bondName];
    $url = routerIP().'/configure';

        $data = [];
        // Check if each variable is empty, and add the corresponding array element only if not empty
        if (!empty($bondMode)) {
            $data[] = [
                'op' => 'set',
                'path' => array_merge($base_path, ['mode', $bondMode])
            ];
        }

        if (!empty($hashPolicy)) {
            $data[] = [
                'op' => 'set',
                'path' => array_merge($base_path, ['hash-policy', $hashPolicy])
            ];
        }

        if (!empty($bondMember)) {
            foreach ($bondMember as $bondMemberVal) {
                $data[] = [
                    'op' => 'set',
                    'path' => array_merge($base_path, ['member', 'interface', $bondMemberVal])
                ];
               
            }
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

// delete bonding
elseif (isset($_POST['action']) && $_POST['action'] == 'delete-bonding'){

  $bondName = $_POST['bondName'];
  $url = routerIP().'/configure';
  $data = [
      [
          'op' => 'delete',
          'path' => ['interfaces', 'bonding', $bondName]
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

// edit bonding
elseif (isset($_POST['action']) && $_POST['action'] == 'edit-bonding'){

    $bondName = $_POST['bondName'];
    $bondMode = $_POST['bondMode'];
    $hashPolicy = $_POST['hashPolicy'];
    $memberInterface = $_POST['memberInterface'];
    $base_path = ['interfaces', 'bonding', $bondName];
    $url = routerIP().'/configure';

    $data = [];

    if (!empty($bondMode)) {
        $data[] = [
            'op' => 'set',
            'path' => array_merge($base_path, ['mode', $bondMode])
        ];
    }
    
    if (!empty($hashPolicy)) {
        $data[] = [
            'op' => 'set',
            'path' => array_merge($base_path, ['hash-policy', $hashPolicy])
        ];
    }
    
    // Ketika status deleteMemberInterface (form select dihapus semua)
    if ($memberInterface === ['deleteMemberInterface']) {
        $data[] = [
            'op' => 'delete',
            'path' => array_merge($base_path, ['member'])
        ];
    } elseif (!empty($memberInterface)) {
        // Jika memberInterface tidak kosong, tambahkan set operation untuk setiap interface
        $nonEmptyInterfaces = array_filter($memberInterface, function($value) {
            return $value !== "";
        });
    
        $data[] = [
            'op' => 'delete',
            'path' => array_merge($base_path, ['member'])
        ];
    
        foreach ($nonEmptyInterfaces as $bondMemberVal) {
            $data[] = [
                'op' => 'set',
                'path' => array_merge($base_path, ['member', 'interface', $bondMemberVal])
            ];
        }
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

// add bonding address
elseif (isset($_POST['action']) && $_POST['action'] == 'add-bonding-address') {

    $bondName = $_POST['bondName'];
    $address = $_POST['address'];
    $url = routerIP().'/configure';

    $data = array(
        'op' => 'set',
        'path' => array('interfaces', 'bonding', $bondName, 'address', $address)
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
            "message" => $response['error']
        );
    }
    
}

// delete bonding address
elseif(isset($_POST['action']) && $_POST['action'] == 'delete-bonding-address') {

    $bondName = $_POST['bondName'];
    $address = $_POST['address'];

    $url = routerIP().'/configure';
    $data = [
        [
            'op' => 'delete',
            'path' => array('interfaces', 'bonding', $bondName, 'address', $address)
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
