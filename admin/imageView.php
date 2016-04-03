<?php
$conn = mysql_connect("localhost", "fjc_us100", "01i6pSBn3Z7Z");
mysql_select_db("fjc_mwall") or die(mysql_error());
if(isset($_GET['image_id'])) {
    $sql = "SELECT type,content FROM upload WHERE user_id=" . $_GET['image_id'];
    $result = mysql_query("$sql") or die("<b>Error:</b> Problem on Retrieving Image BLOB<br/>" . mysql_error());
    $row = mysql_fetch_array($result);
    
    if($row["content"]){
        header("Content-type: " . $row["type"]);
        echo $row["content"];
    }else{
        $sql = "SELECT dimg FROM dpeople WHERE id=" . $_GET['image_id'];
        $result = mysql_query("$sql") or die("<b>Error:</b> Problem on Retrieving Image BLOB<br/>" . mysql_error());
        $row = mysql_fetch_array($result);
        
        header("Content-type: image/png");
        if($row["dimg"]){
            $img = $row["dimg"];     
        }else{
            $img = 'https://fjc.ru/ruwall/images/star.png';
        }
        $file = file_get_contents($img);
        echo $file;
    }
    mysql_close($conn);
}
?>