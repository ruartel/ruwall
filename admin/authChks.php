<?php
require_once '../meekrodb.2.3.class.php';

$json = file_get_contents('php://input');
$obj = json_decode($json);

//var_dump($obj);
if($obj->chk){
    DB::query("UPDATE dpeople set isActive=1 where id in (" . $obj->chk . ")");
    
    ## send tks mail for add the loved one ##
    require_once '../PHPMailer/PHPMailerAutoload.php';
    require_once '../Controller/YizkorMail.php';
    $yMail = new YizkorMail();
    $yMail->authMailToUsers($obj->chk);
    //DB::update('dpeople', array(
    //    'isActive' => 1,
    //), "id in (%s)", $obj->chk);
}