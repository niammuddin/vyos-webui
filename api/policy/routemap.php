<?php
include '../../functions.php';

// get vlan interfaces
if ($_POST['action'] == 'routemap') {
    $url = routerIP().'/retrieve';
    $data = array(
        'op' => 'showConfig',
        'path' => array('policy')
    );

    $jsonData = getAPI($url, $data);
    $data = json_decode($jsonData, true);

    if ($data && isset($data['data']['route-map'])) {
        $formattedData = array();
        $asPathList = $data['data']['route-map'];
    
        foreach ($asPathList as $listName => $listData) {
            $formattedData[] = array(
                'listName' => $listName,
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

    if (isset($data['data']['route-map'])) {
        $formattedData = array();
        $routemap = $data['data']['route-map'];
        foreach ($routemap as $listName => $listData) {
            if (isset($listData['rule'])) {
                foreach ($listData['rule'] as $ruleNumber => $rule) {
                    $formattedData[] = array(
                        'listName' => $listName,
                        'ruleNumber' => $ruleNumber,
                        'action' => isset($rule['action']) ? $rule['action'] : '',
                        'match' => isset($rule['match']) ? json_encode($rule['match']) : '',
                        'set' => isset($rule['set']) ? json_encode($rule['set']) : '',                        
                        'description' => isset($rule['description']) ? $rule['description'] : ''
                    );
                }
            }
        }
    $responseData = array('data' => $formattedData);
    }
}
elseif($_POST['action'] == 'match-table') {
  $url = routerIP().'/retrieve';
  $data = array(
      'op' => 'showConfig',
      'path' => array('policy')
  );

  $jsonData = getAPI($url, $data);
  $data = json_decode($jsonData, true);

  if (isset($data['data']['route-map'])) {
      $formattedData = array();
      $routemap = $data['data']['route-map'];
      foreach ($routemap as $listName => $listData) {
          if (isset($listData['rule'])) {
              foreach ($listData['rule'] as $ruleNumber => $rule) {
                if (isset($rule['match'])) {
                  $formattedData[] = array(
                      'listName' => $listName,
                      'ruleNumber' => $ruleNumber,
                      'match' => isset($rule['match']) ? json_encode($rule['match']) : '',                      
                      'description' => isset($rule['description']) ? $rule['description'] : ''
                  );
                }
              }
          }
      }
  $responseData = array('data' => $formattedData);
  }
}
elseif($_POST['action'] == 'set-table') {
  $url = routerIP().'/retrieve';
  $data = array(
      'op' => 'showConfig',
      'path' => array('policy')
  );

  $jsonData = getAPI($url, $data);
  $data = json_decode($jsonData, true);

  if (isset($data['data']['route-map'])) {
      $formattedData = array();
      $routemap = $data['data']['route-map'];
      foreach ($routemap as $listName => $listData) {
          if (isset($listData['rule'])) {
              foreach ($listData['rule'] as $ruleNumber => $rule) {
                if (isset($rule['set'])) {
                  $formattedData[] = array(
                      'listName' => $listName,
                      'ruleNumber' => $ruleNumber,
                      'set' => isset($rule['set']) ? json_encode($rule['set']) : '',                      
                      'description' => isset($rule['description']) ? $rule['description'] : ''
                  );
                }
              }
          }
      }
  $responseData = array('data' => $formattedData);
  }
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