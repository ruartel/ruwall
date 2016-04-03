<?php
## send Yahrzeit mail every night at 01:00;

require_once 'meekrodb.2.3.class.php';
require_once 'PHPMailer/PHPMailerAutoload.php';
require_once 'Controller/YizkorMail.php';
require_once 'Controller/User.php';

$user = new User();
$allUsers = $user->getAllUsers();

foreach($allUsers as $k=>$v){
    if($v['candle']==1 && ($v['candleDays'] == 3 || $v['candleDays'] == 1)){
        $yMail = new YizkorMail($v['donor_id'],3,$v['id']);
        $yMail->sendMail();
    }
}

//$donor_id=$_GET['donor_id'];
//$type_mail=$_GET['type_mail'];
//$user_id=$_GET['user_id'];
//
//$yMail = new YizkorMail($donor_id, $type_mail,$user_id);
//$yMail->sendMail();
//var_dump($yMail);
