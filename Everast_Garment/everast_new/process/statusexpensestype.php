<?php 
session_start();
if(!isset($_SESSION['userid'])){header ("Location:../index.php");}
require_once('../connection/db.php'); 

$userID=$_SESSION['userid'];
$record=$_GET['record'];
$type=$_GET['type'];

if($type==1){$value=1;}
else if($type==2){$value=2;}
else if($type==3){$value=3;}

$sql="UPDATE `tbl_expences_type` SET `status`='$value',`tbl_user_idtbl_user`='$userID' WHERE `idtbl_expences_type`='$record'";
if($conn->query($sql)==true){header("Location:../expensestype.php?action=$type");}
else{header("Location:../expensestype.php?action=5");}
?>