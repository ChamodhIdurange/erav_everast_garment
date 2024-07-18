<?php
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('connection/db.php');//die('bc');
$userID=$_SESSION['userid'];

$updatedatetime=date('Y-m-d h:i:s');
$filename = "process/stockupdate.csv";
$file = fopen($filename, 'r');
$c = 0;
while (($line = fgetcsv($file)) !== FALSE) {
    $c++;

    $productid = $line[0];
    $qty = $line[4];
    if($c == 1){
        continue;
    }

    $sqlinsert = "INSERT INTO `tbl_stock` (`qty`, `batchqty`, `batchno`, `update`, `status`, `updatedatetime`, `tbl_user_idtbl_user`,`tbl_product_idtbl_product`) Values ('$qty', '$qty', '22110000', '$updatedatetime','1','$updatedatetime','$userID','$productid')";
    $conn->query($sqlinsert);
}

print_r($c);

?>