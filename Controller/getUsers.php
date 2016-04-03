<?php
require_once '../meekrodb.2.3.class.php';
require_once 'User.php';

$json = file_get_contents('php://input');
$obj = json_decode($json);

$user = new User();
if($obj->a == 'getAll'){
    $allUsers = $user->getAllUsers();
//    var_dump($allUsers);
    echo json_encode($allUsers);
}else if($obj->a == 'search'){
    $sUsers = $user->getSUsers($obj->s);
    echo json_encode($sUsers);
}else if($obj->a == 'getById'){
    $uDetails = $user->getUserById($obj->id);
    echo json_encode($uDetails);
}elseif($obj->a == 'getErased'){
    $allUsers = $user->getAllErased();
//    var_dump($allUsers);
    echo json_encode($allUsers);
}