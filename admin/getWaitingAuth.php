<?php
require_once '../meekrodb.2.3.class.php';

$json = file_get_contents('php://input');
$obj = json_decode($json);

$query = 'select dp.*, don.email, CASE WHEN dp.hebrew_date IS NULL or dp.hebrew_date = "" THEN DATE_FORMAT(dp.greg_date,"%b %d %Y") ELSE dp.hebrew_date END AS theDate, upl.content from dpeople dp left join upload upl on upl.user_id=dp.id left join donor don on don.id=dp.donor_id where isActive=0 and isRemoved=0 order by id desc';
$results = DB::query($query);
echo json_encode($results);