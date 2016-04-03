<?php
require_once 'meekrodb.2.3.class.php';
require_once 'Controller/User.php';
require_once 'Controller/Lead.php';

$ids=$_GET['ids'];
$arrID = explode(',', $ids);
$donor_id = $arrID[0];
$user_id = $arrID[1];
#### update transsaction id and echo true
DB::update('donor', array(
    'payment_status' => 'approved',
    'payment_method' => 'PayPal'
), "id=%i", $donor_id);

header('Location: https://yizkorwall.org/d/d.php?id=' . $user_id);

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

