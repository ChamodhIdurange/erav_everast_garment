<?php 
session_start();
if(!isset($_SESSION['userid'])){header ("Location:../index.php");}
require_once('../connection/db.php'); 

$userID=$_SESSION['userid'];
$record=$_GET['record'];
$type=$_GET['type'];
$currentDate = date('mdY');
$updatedatetime = date('Y-m-d h:i:s');

if($type==1){$value=1;}
else if($type==2){$value=2;}
else if($type==3){$value=3;}
$batchNo = "RMV" . $currentDate . $record;

$sql="UPDATE `tbl_invoice` SET `paymentcomplete`='$value',`tbl_user_idtbl_user`='$userID' WHERE `idtbl_invoice`='$record'";
if($conn->query($sql)==true){
    header("Location:../invoiceview.php?action=$type");
}
else{
    header("Location:../invoiceview.php?action=5");
}
?>