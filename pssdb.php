<?php
require_once 'functions.php';
# just copy the db
$all = getAllLeads();

$dbh1 = mysql_connect('localhost', 'fjc_us100', '01i6pSBn3Z7Z'); 
mysql_select_db('fjc_mwall', $dbh1);
mysql_set_charset('utf8');

$insertQuery = "insert into donor (fname,lname,email,donation_type,suggested_donation, cdate,payment_method,ip) values ";
$counter=0;
foreach ($all as $k=>$v){
    #lets build the insert
    # donor query
    $query = 'select rld.id, rld.date_created,rld.ip,
                rdd.value as firstName,
                rdd2.value as lastName,
                rdd8.value as wallName1,
                rdd9.value as wallName2,
                rdd10.value as wallName3,
                rdd4.value as email,
                rdd5.value as vdate,
                rdd6.value as payment_amount,
                rdd11.value as payment_method,
                rdd7.value as pageFrom

                FROM wp_rg_lead rld
                LEFT JOIN wp_rg_lead_detail rdd ON rdd.lead_id = rld.id and rdd.field_number=1
                LEFT JOIN wp_rg_lead_detail rdd2 ON rdd2.lead_id = rld.id and rdd2.field_number=2
                LEFT JOIN wp_rg_lead_detail rdd4 ON rdd4.lead_id = rld.id and rdd4.field_number=4
                LEFT JOIN wp_rg_lead_detail rdd5 ON rdd5.lead_id = rld.id and rdd5.field_number=28
                LEFT JOIN wp_rg_lead_detail rdd6 ON rdd6.lead_id = rld.id and rdd6.field_number=26
                LEFT JOIN wp_rg_lead_detail rdd7 ON rdd7.lead_id = rld.id and rdd7.field_number=18
                LEFT JOIN wp_rg_lead_detail rdd8 ON rdd8.lead_id = rld.id and rdd8.field_number=8
                LEFT JOIN wp_rg_lead_detail rdd9 ON rdd9.lead_id = rld.id and rdd9.field_number=9
                LEFT JOIN wp_rg_lead_detail rdd10 ON rdd10.lead_id = rld.id and rdd10.field_number=10
                LEFT JOIN wp_rg_lead_detail rdd11 ON rdd11.lead_id = rld.id and rdd11.field_number=32
                WHERE rld.form_id in (19) and rld.id=' . $v['id'];
    
//    echo $query;
    $results = DB::query($query);

    $ip = $results[0]['ip'];
    $cdate = $results[0]['date_created'];
    $currency = $results[0]['currency'];
    $payment_amount = $results[0]['payment_amount'];
    $payment_date = $results[0]['payment_date'];
    $payment_method = $results[0]['payment_method'];
    
    if($payment_method == NULL){
        $payment_method = '0';
    }
   $payment_amount = mysql_escape_string($payment_amount);
   $payment_method = mysql_escape_string($payment_method);
   $payment_date = mysql_escape_string($payment_date);
   $donation_place = mysql_escape_string($v['donation_place']);
   $suggested_donation = mysql_escape_string($v['suggested_donation']);
   
   $fname = $v['lead_fname'];
   $lname = $v['lead_lname'];
    if($counter == 0){
        $insertQuery .= "('$fname','$lname','{$v['email']}','$donation_place','$suggested_donation','$cdate','$payment_method','$ip')";    
    }else{
        $insertQuery .= ",('$fname','$lname','{$v['email']}','$donation_place','$suggested_donation','$cdate','$payment_method','$ip')";
    
    }
    $counter++;
}
var_dump($insertQuery);
$ii = mysql_query($insertQuery, $dbh1);
    
    echo '</br>';
    var_dump($ii);
    echo '</br>';
    


