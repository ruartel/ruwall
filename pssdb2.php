<?php

require_once 'functions.php';
# just copy the db
$all = getAllLeads();

$dbh1 = mysql_connect('localhost', 'fjc_us100', '01i6pSBn3Z7Z'); 
mysql_select_db('fjc_mwall', $dbh1);
mysql_set_charset('utf8');

$counter=0;
$insertQuery = "insert into dpeople (`first_name`, `last_name`, `datetype`, `hebrew_date`, `greg_date`, `dtext`, `special_donation`, `isActive`, `donor_id`, `dimg`, `hname`) values";
foreach ($all as $k=>$v){
    #this get all donors
    $res = mysql_query('select id from donor where email="' . $v['email'] . '"', $dbh1);
    while ($row = mysql_fetch_assoc($res)) {
        $donor_id=$row['id'];
//        var_dump($row['id']);
    }
    
    $fname = mysql_real_escape_string($v['user_fname']);
    $lname = mysql_real_escape_string($v['user_lname']);
    $hebrew_name = mysql_real_escape_string($v['user_hebrew_name']);
    $dtext = mysql_real_escape_string($v['user_text']);
    $pic = mysql_real_escape_string($v['src']);
    $greg_date = mysql_real_escape_string($v['greg_date']);
    $date_type = mysql_real_escape_string($v['date_type']);
    $hebrew_date = mysql_real_escape_string($v['hebrew_date']);
    if(!$hebrew_date){
        $hebrew_date = null;
    }
    if($counter == 0){
        $insertQuery .= "('$fname','$lname','$date_type',";
        $insertQuery .=  "'$hebrew_date'";
        $insertQuery .=  ",'$greg_date','$dtext','0','1','$donor_id','$pic','$hebrew_name')";    
    }else{
        $insertQuery .= ",('$fname','$lname','$date_type',";
        $insertQuery .=  "'$hebrew_date'";
        $insertQuery .=  ",'$greg_date','$dtext','0','1','$donor_id','$pic','$hebrew_name')";      
    
    }
    $counter++;
}
var_dump($insertQuery);
$ii = mysql_query($insertQuery, $dbh1);
    
    echo '</br>';
    var_dump($ii);
    echo '</br>';