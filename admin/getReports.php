<?php
require_once '../meekrodb.2.3.class.php';

$json = file_get_contents('php://input');
$obj = json_decode($json);

$query = 'select count(id) as total from donor';
$resDonor = DB::query($query);

$query = 'select count(id) as total from donor WHERE suggested_donation = "Not now, thanks"';
$resDonor2 = DB::query($query);

$query = 'select count(id) as total from donor WHERE suggested_donation != "Not now, thanks"';
$resDonor3 = DB::query($query);

$query = 'select count(id) as total from dpeople WHERE isRemoved=0';
$resPeople = DB::query($query);

$query = 'select count(id) as total from dpeople WHERE isRemoved=1';
$resPeople2 = DB::query($query);

$results = array();
$results[0] = array();
$results[0]['name'] = 'Donors Total';
$results[0]['quantity'] = $resDonor[0]['total'];

$results[1] = array();
$results[1]['name'] = 'Approved Cards';
$results[1]['quantity'] = $resPeople[0]['total'];

$results[2] = array();
$results[2]['name'] = 'Removed Cards';
$results[2]['quantity'] = $resPeople2[0]['total'];

$results[3] = array();
$results[3]['name'] = 'Donors - Not now, thanks';
$results[3]['quantity'] = $resDonor2[0]['total'];

$results[4] = array();
$results[4]['name'] = 'Donors - Number of donations';
$results[4]['quantity'] = $resDonor3[0]['total'];

echo json_encode($results);