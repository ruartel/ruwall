<?php
require_once '../meekrodb.2.3.class.php';
if(isset($_GET['username']) && isset($_GET['password'])){
    $user = filter_var($_GET['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pass = filter_var($_GET['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $usr_id = DB::queryOneField('id', "SELECT * FROM mem_users WHERE password=%s and username=%s", $pass,$user);
    if($usr_id){
        #setcookie("mem-admin", $usr_id . '*' . $user);
        echo $usr_id;
    }else{
        echo 0;
    }
}else{
    echo 0;
}