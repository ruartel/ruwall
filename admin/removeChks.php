<?php
require_once '../meekrodb.2.3.class.php';

$json = file_get_contents('php://input');
$obj = json_decode($json);

var_dump($obj->chk);
if($obj->chk){
    DB::query("UPDATE dpeople set isRemoved=1 where id in (" . $obj->chk . ")");
    //DB::update('dpeople', array(
    //    'isActive' => 0,
    //), "id in (%s)", $obj->chk);
}