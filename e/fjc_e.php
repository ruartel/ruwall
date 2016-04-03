<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/meekrodb.fjc.php';
require_once dirname(__FILE__) . '/phpExcel/Classes/PHPExcel.php';

function getNameFromNumber($num) {
    $numeric = ($num - 1) % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval(($num - 1) / 26);
    if ($num2 > 0) {
        return getNameFromNumber($num2) . $letter;
    } else {
        return $letter;
    }
}

$arrNames=array();
$arrNames[0]='id';
$arrNames[11]='name';
$arrNames[12]='last_name';
$arrNames[15]='email';
$arrNames[28]='vdate';
$arrNames[26]='payment_amount';
$arrNames[7]='cause';
$arrNames[9]='Note';
$arrNames[14]='payment_type';
$arrNames[20]='city';
$arrNames[19]='fn';
$arrNames[50]='title';
$arrNames[51]='transaction_id';
$arrNames[52]='amount';
$arrNames[53]='amount2';
$arrNames["19.1"]='address1';
$arrNames["19.3"]='address2';
$arrNames["19.4"]='state';
$arrNames["19.5"]='zip';
$arrNames["19.6"]='country';

$arrToExcel=array();
$arrToExcel[0]='A';
$arrToExcel[11]='B';
$arrToExcel[12]='C';
$arrToExcel[15]='D';
$arrToExcel[28]='E';
$arrToExcel[26]='F';
$arrToExcel[7]='G';
$arrToExcel[9]='H';
$arrToExcel[14]='I';
$arrToExcel[20]='J';
$arrToExcel[19]='K';
$arrToExcel[50]='L';
$arrToExcel[51]='M';
$arrToExcel[52]='N';
$arrToExcel[53]='O';
$arrToExcel["19.1"]='P';
$arrToExcel["19.3"]='Q';
$arrToExcel["19.4"]='R';
$arrToExcel["19.5"]='S';
$arrToExcel["19.6"]='T';

$arr = array();
$result = DB::query('select id, date_created,payment_amount,transaction_id,form_id FROM wp_rg_lead WHERE payment_amount IS NOT NULL');
//var_dump($result);
foreach ($result as $k => $u){
    $arr[$u['id']]=array();
    $arr[$u['id']][28] = $u['date_created'];
    $arr[$u['id']][26] = $u['payment_amount'];
    $details = DB::query('select * FROM wp_rg_lead_detail WHERE value IS NOT NULL and lead_id =' . $u['id']);
    foreach ($details as $d=>$l){
//        var_dump($l);
        if(isset($arrNames[$l['field_number']])){
            $arr[$u['id']][$l['field_number']] = $l['value'];
        }
    }
    $details2 = DB::query('select * FROM wp_rg_paypal_transaction WHERE transaction_id ="' . $u['transaction_id'] . '"');
    $details3 = DB::query('select * FROM wp_rg_paypalpaymentspro_transaction WHERE transaction_id ="' . $u['transaction_id'] . '"');
    $details4 = DB::query('select title FROM wp_rg_form WHERE id =' . $u['form_id']);
    
    $arr[$u['id']][50] = $details4[0]['title'];
    if(isset($details2[0]['transaction_id'])){
        $arr[$u['id']][51] = $details2[0]['transaction_id'];
        $arr[$u['id']][52] = $details2[0]['amount'];
    }else{
        $arr[$u['id']][51] = '';
        $arr[$u['id']][52] = '';
    }
    if(isset($details3[0]['amount'])){
        $arr[$u['id']][53] = $details3[0]['amount'];
    }else{
        $arr[$u['id']][53] = '';
    }
}

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Gla Solutions");

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'id')
            ->setCellValue('B1', 'name')
            ->setCellValue('C1', 'last_name')
            ->setCellValue('D1', 'email')
            ->setCellValue('E1', 'vdate')
            ->setCellValue('F1', 'payment_amount')
            ->setCellValue('G1', 'cause')
            ->setCellValue('H1', 'Note')
            ->setCellValue('I1', 'payment_type')
            ->setCellValue('J1', 'city')
            ->setCellValue('K1', 'fn')
            ->setCellValue('L1', 'title')
            ->setCellValue('M1', 'transaction_id')
            ->setCellValue('N1', 'amount')
            ->setCellValue('O1', 'amount2')
            ->setCellValue('P1', 'address1')
            ->setCellValue('Q1', 'address2')
            ->setCellValue('R1', 'state')
            ->setCellValue('S1', 'zip')
            ->setCellValue('T1', 'country');


$row = 2;
foreach ($arr as $k => $v){
    $cur_col = $arrToExcel[0];
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cur_col . $row, $k);
    foreach ($v as $l=>$vv){
        $cur_col = $arrToExcel[$l];
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cur_col . $row, $vv);
    }
    $row++;
    
}

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="fjc_e.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;