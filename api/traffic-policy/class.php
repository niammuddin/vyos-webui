<?php
include '../../functions.php';
$url = routerIP().'/retrieve';
$data = array(
    'op' => 'showConfig',
    'path' => array('traffic-policy')
);
$jsonData = getAPI($url, $data);

$data = json_decode($jsonData, true);

$tableData = array();
$recordsTotal = 0;
$recordsFiltered = 0;


if (isset($data['data']['shaper'])) {
  $shaperData = $data['data']['shaper'];


  foreach ($shaperData as $shaperName => $shaper) {
    if (isset($shaper['class'])) {
      foreach ($shaper['class'] as $classId => $classData) {
        $match = '';

        if (isset($classData['match'])) {
          // Ambil semua kunci dari array $classData['match']
          $match = implode(', ', array_keys($classData['match']));
        }
        
        $rowData = array(
          'classId' => $classId,
          'shaperName' => $shaperName,
          'bandwidth' => isset($classData['bandwidth']) ? $classData['bandwidth'] : '',
          'burst' => isset($classData['burst']) ? $classData['burst'] : '',
          'match' => $match,
          'queueType' => isset($classData['queue-type']) ? $classData['queue-type'] : '',
          'description' => isset($classData['description']) ? $classData['description'] : '',
        );

        $tableData[] = $rowData;
      }
    }
  }


  $recordsTotal = count($tableData);


  $draw = isset($_GET['draw']) ? intval($_GET['draw']) : 1;


  $recordsFiltered = $recordsTotal;


  $response = array(
    'draw' => $draw,
    'recordsTotal' => $recordsTotal,
    'recordsFiltered' => $recordsFiltered,
    'data' => $tableData
  );

} else {

  $response = array(
    'draw' => isset($_GET['draw']) ? intval($_GET['draw']) : 1,
    'recordsTotal' => 0,
    'recordsFiltered' => 0,
    'data' => array()
  );
}


$jsonResponse = json_encode($response);


echo $jsonResponse;
?>
