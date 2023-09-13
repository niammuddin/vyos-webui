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
        if (isset($classData['match'])) {
          foreach ($classData['match'] as $matchName => $matchData) {
            // Ganti nilai null dengan kosong ('')
            $interface = isset($matchData['interface']) ? $matchData['interface'] : '';
            $dstIP = isset($matchData['ip']['destination']['address']) ? $matchData['ip']['destination']['address'] : '';
            $srcIP = isset($matchData['ip']['source']['address']) ? $matchData['ip']['source']['address'] : '';
            $description = isset($matchData['description']) ? $matchData['description'] : '';

            $rowData = array(
              'shaperName' => $shaperName,
              'classId' => $classId,
              'match' => $matchName,
              'interface' => $interface,
              'dstIP' => $dstIP,
              'srcIP' => $srcIP,
              'description' => $description,
            );

            $tableData[] = $rowData;
          }
        }
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
