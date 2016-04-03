<?php
require_once 'meekrodb.2.3.class.php';

function linkNumField($n){
    $f=array();
    $f[0]='';
    $f[1]='lead_fname';
    $f[2]='lead_lname';
    $f[3]='';
    $f[4]='email';
    $f[5]='src';
    $f[8]='user_fname';
    $f[9]='user_lname';
    $f[10]='user_hebrew_name';
    $f[14]='user_text';
    $f[16]='donation_place';
    $f[17]='user_title';
    $f[18]='';#https
    $f[19]='transaction_id';#some number
    $f[21]='';#yes
    $f[22]='d_day';
    $f[23]='d_month';
    $f[25]='d_year';
    $f[26]='suggested_donation';
    $f[28]='greg_date';
    $f[31]='date_type';
    $f[35]='';#no
    $f[36]='hebrew_date';
    
    return $f[$n];
}

function buildLeadArr($results){
    $leads = array();
    $row_count = 0;
    foreach ($results as $row) {
        $leads[$row_count] = array();
        $leads[$row_count]['id'] = $row['lead_id'];
        ## explde the string
        $cur_Bstr = explode('|', $row['fields']);
        foreach($cur_Bstr as $sStr){
            $cur_Sstr = explode(':', $sStr, 2);
            $c_field = linkNumField($cur_Sstr[0]);
            $leads[$row_count][$c_field] = $cur_Sstr[1];
        }
        $row_count++;
    }
    return $leads;
}

function getAllLeads(){
    ### get all lead details
//    $query ="SELECT lead_id,"
//            . "GROUP_CONCAT(DISTINCT CONCAT(field_number, ':',value) "
//            . "ORDER BY field_number SEPARATOR '|') as fields "
//            . "from wp_rg_lead_detail "
//            . "where form_id=19 group by lead_id ORDER BY lead_id DESC;";
//    
    $query = 'select * from dpeople order by id desc';

    $results = DB::query($query);
    return buildLeadArr($results);
}

function getLeadById($id) {
    $query = "SELECT lead_id,GROUP_CONCAT(DISTINCT CONCAT(field_number, ':',value) ORDER BY field_number SEPARATOR '|') AS fields
           from wp_rg_lead_detail 
           where form_id=19 AND lead_id=$id
           group by lead_id ;";

    $results = DB::query($query);
    return buildLeadArr($results);
}



### this get id
//$query ="SELECT lead_id from wp_rg_lead_detail where form_id=19 AND ( field_number = 21) group by lead_id;";
//$results = DB::query($query);
//foreach ($results as $row) {
//    var_dump($row);
//}

### this get names
//$auto  = "SELECT value FROM "
//        . "(SELECT lead_id,GROUP_CONCAT(DISTINCT CONCAT(value) ORDER BY field_number SEPARATOR ' ') "
//        . "AS value "
//        . "from wp_rg_lead_detail "
//        . "where form_id=19 "
//        . "AND ( field_number IN (8,9)) group by lead_id) as names";
//
//$results = DB::query($auto);
//foreach ($results as $row) {
//    var_dump($row);
//    
//    echo '</br>';
//    echo '</br>';
//}
//

#### get all leads #####
//$leads = getAllLeads();
//var_dump($leads);
#### get all leads #####
//$lead = getLeadById(2386);
//var_dump($lead);
