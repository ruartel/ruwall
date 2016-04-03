<?php
//var_dump($_GET['gy']);
// create curl resource 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://www.hebcal.com/converter/?cfg=json&gy=' . $_GET['gy'] . '&gm=' . $_GET['gm'] . '&gd=' . $_GET['gd'] . '&g2h=1'); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$output = curl_exec($ch); 
curl_close($ch);      

//var_dump($output);

echo $output;