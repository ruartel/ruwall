<?php
require_once 'meekrodb.2.3.class.php';
//require_once 'html2pdf/html2pdf.class.php';

//$filename = $_FILES['file']['name'];
//$filename = time();
//$destination = 'images/users/' . $filename;
//move_uploaded_file( $_FILES['file']['tmp_name'] , $destination );
$cID = $_GET['id'];
$fileName = 'user_' . $cID;
$tmpName  = $_FILES['file']['tmp_name'];
$fileSize = $_FILES['file']['size'];
$fileType = $_FILES['file']['type'];
//
$fp      = fopen($tmpName, 'r');
$content1 = fread($fp, filesize($tmpName));
$content = addslashes($content1);
fclose($fp);

$ftt = explode('/',$fileType);
$fType = $ftt[1];

$filePath = 'images/users/' . $fileName . '.' . $fType;

$myfile = fopen($filePath, "w");
fwrite($myfile, $content1);
fclose($myfile);

//if(!get_magic_quotes_gpc())
//{
//    $fileName = addslashes($fileName);
//}
//
//$query = "INSERT INTO upload (name, user_id, size, type, content ) ".
//"VALUES ('$fileName','$cID', '$fileSize', '$fileType', '$content')";
//
//DB::query($query);

DB::update('dpeople', array(
    'dimg' => 'https://yizkorwall.org/' . $filePath
), "id=%i", $cID);

#### trying to create image ####
//$html_content = file_get_contents('https://yizkorwall.org/d/d.php?id=' . $cID);
//
//$html2pdf = new HTML2PDF('P', 'A4');
//$html2pdf->writeHTML($html_content);
//$file = $html2pdf->Output('temp.pdf','F');
//
//$im = new imagick('temp.pdf');
//$im->setImageFormat( "jpg" );
//$img_name = time().'.jpg';
//$im->setSize(1200,630);
//$im->writeImage($img_name);
//$im->clear();
//$im->destroy();
