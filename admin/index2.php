<?php
require_once '../meekrodb.2.3.class.php';

#the first thing is to check if the user is logged in.
#if is looged go on, if not go to log in page
if(isset($_COOKIE['mem-admin'])){
    $cookie = filter_var($_COOKIE['mem-admin'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $cookArr = explode('*', $cookie);
    $id=$cookArr[0];
    $username=$cookArr[1];
    ## check if id exist
    $usr_id = DB::queryOneField('id', "SELECT * FROM mem_users WHERE id=%i and username=%s", $id,$username);
    if($usr_id){
        echo TRUE;
    }else{
        echo FALSE;
    }
}else{
    echo FALSE;
}
