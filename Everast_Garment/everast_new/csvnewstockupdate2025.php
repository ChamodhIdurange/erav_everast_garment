<?php
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('connection/db.php');//die('bc');
$userID=$_SESSION['userid'];

$updatedatetime=date('Y-m-d h:i:s');
$filename = "process/stockupdate2025.csv";

$file1 = fopen($filename, 'r');
$file2 = fopen($filename, 'r');
$c = 0;
$x = 0;
$month = date('m');
$year = substr(date('y'), -2);;

$total = 0;




$batchNo = $year.$month.sprintf('%04s', '01');

while (($line = fgetcsv($file2)) !== FALSE) {
    $x++;
    $productId = $line[0];
    $retailPrice = $line[4];
    $wholePrice = $line[5];
    $unitPrice = $line[7];
    $qty = $line[8];

    if($x == 1){
        continue;
    }

    $sqlupdate = "UPDATE `tbl_product` SET `saleprice` = '$retailPrice', `retail` = '$wholePrice', `unitprice` = '$unitPrice' WHERE `idtbl_product` = '$productId'";
    $conn->query($sqlupdate);

    $insertstock="INSERT INTO `tbl_stock` (`batchqty`, `qty`, `update`, `status`, `batchno`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_product_idtbl_product`) VALUES ('$qty', '$qty', '$updatedatetime', '1', '$batchNo', '$updatedatetime', '$userID', '$productId')";
    $conn->query($insertstock);
}



print_r($x);

?>