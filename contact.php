<?php
## send subscription mail
require_once 'meekrodb.2.3.class.php';
require_once 'PHPMailer/PHPMailerAutoload.php';
require_once 'Controller/YizkorMail.php';

$json = file_get_contents('php://input');
$obj = json_decode($json);

$yMail = new YizkorMail();
$yMail->mailMe($obj);
//var_dump($yMail);
