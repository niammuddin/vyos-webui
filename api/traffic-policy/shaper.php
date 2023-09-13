<?php
include '../../functions.php';
$url = routerIP().'/retrieve';
$data = array(
    'op' => 'showConfig',
    'path' => array('traffic-policy')
);
$jsonData = getAPI($url, $data);
$data = json_decode($jsonData, true);

$recordTotal = 0;
$filterTotal = 0;

if (isset($data['data']['shaper'])) {
  
  $shaperData = $data['data']['shaper'];

  $tableData = array();
  foreach ($shaperData as $shaperName => $shaper) {
    $rowData = array(
        'shaperName' => $shaperName,
        'bandwidth' => $shaper['bandwidth'],
        'defaultBandwidth' => isset($shaper['default']['bandwidth']) ? $shaper['default']['bandwidth'] : '',
        'defaultBurst' => isset($shaper['default']['burst']) ? $shaper['default']['burst'] : '',
        'defaultQueueType' => isset($shaper['default']['queue-type']) ? $shaper['default']['queue-type'] : '',
        'description' => isset($shaper['description']) ? $shaper['description'] : '',
    );
    $tableData[] = $rowData;
  }

  $recordTotal = count($tableData);

  $start = isset($_GET['start']) ? intval($_GET['start']) : 0;
  $length = isset($_GET['length']) ? intval($_GET['length']) : 10;
  $searchValue = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';


  if (!empty($searchValue)) {
    $filteredData = array_filter($tableData, function ($row) use ($searchValue) {
      return (stripos($row['shaperName'], $searchValue) !== false ||
              stripos($row['bandwidth'], $searchValue) !== false ||
              stripos($row['defaultBandwidth'], $searchValue) !== false ||
              stripos($row['defaultBurst'], $searchValue) !== false ||
              stripos($row['defaultQueueType'], $searchValue) !== false ||
              stripos($row['description'], $searchValue) !== false);
    });

    $tableData = array_values($filteredData);
  }


  $filterTotal = count($tableData);


  $response = array(
    'draw' => isset($_GET['draw']) ? intval($_GET['draw']) : 0,
    'recordsTotal' => $recordTotal,
    'recordsFiltered' => $filterTotal,
    'data' => array_slice($tableData, $start, $length),
  );
} else {

  $response = array(
    'draw' => isset($_GET['draw']) ? intval($_GET['draw']) : 0,
    'recordsTotal' => 0,
    'recordsFiltered' => 0,
    'data' => array(),
  );
}

echo json_encode($response);
?>
