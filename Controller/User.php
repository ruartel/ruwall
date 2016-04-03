<?php

class User{
    
    function __construct() {
        
    }
    
    public function getAllUsers() {
        ### get all lead details
//        $query ="SELECT lead_id,"
//                . "GROUP_CONCAT(DISTINCT CONCAT(field_number, ':',value) "
//                . "ORDER BY field_number SEPARATOR '|') as fields "
//                . "from wp_rg_lead_detail "
//                . "where form_id=19 group by lead_id ORDER BY lead_id DESC;";
        $query = 'select *, DATE_FORMAT(greg_date,"%b %d %Y") as american_greg_date, CASE WHEN hebrew_date IS NULL or hebrew_date = "" THEN DATE_FORMAT(greg_date,"%b %d %Y") ELSE hebrew_date END AS theDate from dpeople where isActive=1 and isRemoved=0 order by id desc';
        $results = DB::query($query);
        $y = date('Y');
        $m = date('m');
        $d = date('d');
        $hebDate2 = jdtojewish(gregoriantojd($m,$d,$y));//, true,CAL_JEWISH_ADD_GERESHAYIM + CAL_JEWISH_ADD_ALAFIM + CAL_JEWISH_ADD_ALAFIM_GERESH
        $hebArr2 = explode('/', $hebDate2);
        $cy = $hebArr2[2];
        foreach ($results as $k=>$v){
            if($v['greg_date']){
                $xdate = explode('-', $v['greg_date']);
                $hebDate = jdtojewish(gregoriantojd($xdate[1],$xdate[2],$xdate[0]));//, true,CAL_JEWISH_ADD_GERESHAYIM + CAL_JEWISH_ADD_ALAFIM + CAL_JEWISH_ADD_ALAFIM_GERESH
                $hebArr = explode('/', $hebDate);
                $cd = $hebArr[1];
                $cm = $hebArr[0];
                $newHebDate = $cm . '/' . $cd . '/' . $cy;
                $calc =  strtotime($hebDate2) - strtotime($newHebDate);
                $calcDays = $calc/86400;
                if($calcDays < 7 && $calcDays > -7){
                    $results[$k]['candle'] = 1;
                    $results[$k]['candleDays'] = $calcDays;
                }else{
                    $results[$k]['candle'] = 0;
                }
            }
        }
        
        function cmp($a, $b) {
            return strcmp($b["candle"],$a["candle"]);
        }
        
        usort($results, "cmp");
        
        return $results;
    }
    
    public function getUserById($id){
//        $query = "SELECT lead_id,GROUP_CONCAT(DISTINCT CONCAT(field_number, ':',value) ORDER BY field_number SEPARATOR '|') AS fields
//           from wp_rg_lead_detail 
//           where form_id=19 AND lead_id=%i
//           group by lead_id ;";
        $query = 'select *, DATE_FORMAT(greg_date,"%b %d %Y") as american_greg_date from dpeople where id=' . $id;
        $results = DB::query($query, $id);
        return $results;
    }
    
    public function getSUsers($s) {
        $query = 'select id
        from dpeople
        where isActive=1 and isRemoved=0 and (first_name LIKE "%' . $s . '%" or last_name LIKE "%' . $s . '%" or dtext LIKE "%' . $s . '%" or hname LIKE "%' . $s . '%")
        order by id desc';
        $results = DB::query($query);
        return $results;
    }
    
    public function getAllErased() {
        
        $query = 'select *, DATE_FORMAT(greg_date,"%b %d %Y") as american_greg_date, CASE WHEN hebrew_date IS NULL or hebrew_date = "" THEN DATE_FORMAT(greg_date,"%b %d %Y") ELSE hebrew_date END AS theDate from dpeople where isRemoved=1 order by id desc';
        $results = DB::query($query);
        $y = date('Y');
        $m = date('m');
        $d = date('d');
        $hebDate2 = jdtojewish(gregoriantojd($m,$d,$y));//, true,CAL_JEWISH_ADD_GERESHAYIM + CAL_JEWISH_ADD_ALAFIM + CAL_JEWISH_ADD_ALAFIM_GERESH
        $hebArr2 = explode('/', $hebDate2);
        $cy = $hebArr2[2];
        foreach ($results as $k=>$v){
            if($v['greg_date']){
                $xdate = explode('-', $v['greg_date']);
                $hebDate = jdtojewish(gregoriantojd($xdate[1],$xdate[2],$xdate[0]));//, true,CAL_JEWISH_ADD_GERESHAYIM + CAL_JEWISH_ADD_ALAFIM + CAL_JEWISH_ADD_ALAFIM_GERESH
                $hebArr = explode('/', $hebDate);
                $cd = $hebArr[1];
                $cm = $hebArr[0];
                $newHebDate = $cm . '/' . $cd . '/' . $cy;
                $calc =  strtotime($hebDate2) - strtotime($newHebDate);
                $calcDays = $calc/86400;
                if($calcDays < 7 && $calcDays > -7){
                    $results[$k]['candle'] = 1;
                    $results[$k]['candleDays'] = $calcDays;
                }else{
                    $results[$k]['candle'] = 0;
                }
            }
        }
        return $results;
    }
    
}
    