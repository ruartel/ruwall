<?php
require_once '../meekrodb.2.3.class.php';

$json = file_get_contents('php://input');
$obj = json_decode($json);

$query = 'select * from donor order by id desc';
$results = DB::query($query);
echo json_encode($results);