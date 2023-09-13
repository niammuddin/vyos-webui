<?php
include '../../functions.php';

if ($_POST['action'] == 'static-route') {
    $url = routerIP().'/retrieve';
    $data = array(
        'op' => 'showConfig',
        'path' => array('protocols', 'static', 'route')
    );

    $jsonData = getAPI($url, $data);


    $data = json_decode($jsonData, true);


    $routes = $data['data']['route'];

    $draw = $_POST['draw']; // Jumlah kali request
    $start = $_POST['start']; // Indeks data mulai
    $length = $_POST['length']; // Jumlah data yang ditampilkan per halaman
    $searchValue = $_POST['search']['value']; // Nilai pencarian

    $totalData = count($routes);

    $filteredRoutes = array_filter($routes, function ($route) use ($searchValue) {
        return stripos($route['next-hop'], $searchValue) !== false;
    });


    $totalFiltered = count($filteredRoutes);

    $pagedRoutes = array_slice($filteredRoutes, $start, $length);

    $responseData = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => array(),
    );


    $responseData = ['data' => []];

    foreach ($pagedRoutes as $prefix => $value) {
        $nextHops = $value['next-hop'];
        $nextHopData = [];
    
        foreach ($nextHops as $ip => $nextHopInfo) {
            $distance = isset($nextHopInfo['distance']) ? ' -> <span class="badge bg-primary">'.$nextHopInfo['distance'].'</span>' : '';
            $nextHopData[] = "$ip $distance";
        }
    
        $data = [
            'prefix' => $prefix,
            'nextHop' => implode(', ', $nextHopData)
        ];
    
        $responseData['data'][] = $data;
    }

}
elseif($_POST['action'] == 'add-static-route'){

    $prefix = trim($_POST['prefix']);
    $nextHop = trim($_POST['nextHop']);

    $url = routerIP().'/configure';

    $data = [
        'op' => 'set',
        'path' => ['protocols', 'static', 'route', $prefix, 'next-hop', $nextHop]
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
elseif($_POST['action'] == 'delete-static-route'){

    $prefix = $_POST['prefix'];
    $nextHop = $_POST['nextHop'];

    $url = routerIP().'/configure';

    $data = [
        'op' => 'delete',
        'path' => ['protocols', 'static', 'route', $prefix]
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


else {
    $responseData = array(
        "success" => false,
        "message" => 'access denied'
    );
}

echo json_encode($responseData);