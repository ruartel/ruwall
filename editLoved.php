<?php

require_once 'meekrodb.2.3.class.php';
require_once 'Controller/User.php';
require_once 'Controller/Lead.php';
#this s the edit loved page.
#i still need to check if the user have autorization to edit it!
$json = file_get_contents('php://input');
$obj = json_decode($json);

$token = '';
// function to read stdin
function read_stdin() {
        $fr=fopen("php://stdin","r");   // open our file pointer to read from stdin
        $input = fgets($fr,128);        // read a maximum of 128 characters
        $input = rtrim($input);         // trim any trailing spaces.
        fclose ($fr);                   // close the file handle
        return $input;                  // return the text entered
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function saveUser($obj, $user_id){
    $duserArr = $obj->p->user;
    foreach ($duserArr as $k=>$duser){
    //    $uFirstName=filter_var($duser->fname, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //    $uLastName=filter_var($duser->lname, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //    $uHname=filter_var($duser->hebrew_name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //    $uDesc=filter_var($duser->description, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //    $uGdate=filter_var($duser->greg_date, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //    $uHdate=filter_var($duser->hebrew_date, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $uFirstName=$duser->fname;
        $uLastName=$duser->lname;
        $uHname=$duser->hebrew_name;
        $uDesc=$duser->description;
        $uGdate=$duser->greg_date;
        $uHdate=$duser->hebrew_date;
//        var_dump($uGdate);
        $time = strtotime($uGdate . "+1 days");
        $teDate = date('Y-m-d', $time);
//        var_dump($teDate);
        $row_user = array();
        $row_user['first_name'] = $uFirstName;
        $row_user['last_name'] = $uLastName;
        $row_user['hname'] = $uHname;
        $row_user['dtext'] = $uDesc;
        $row_user['greg_date'] = $teDate;
        $row_user['hebrew_date'] = $uHdate;
        if($duser->deleteImg){
            $row_user['dimg'] = '';
        }
//        $row_user['isActive'] = 0;
//        $row_user['donor_id'] = $donor_id;

        $result2 = DB::update('dpeople',$row_user, "id=%i", $user_id);
//        $user_id = DB::insertId();
        return $result2;
    //    var_dump($result2);
    }
}
$user_id = $obj->user_id;
$res = saveUser($obj, $user_id);
echo $res;
