<?php 
session_start();
if(!isset($_SESSION['userid'])){header ("Location:../index.php");}
require_once('../connection/db.php'); 

$userID=$_SESSION['userid'];
$record=$_GET['record'];
// $type=$_GET['type'];

$sqlReturn = "SELECT `returntype` FROM `tbl_return` WHERE `idtbl_return` = '$record'";
$resultReturn=$conn->query($sqlReturn);
$rowReturn = $resultReturn-> fetch_assoc();
$type =  $rowReturn['returntype'];



$sql="UPDATE `tbl_return` SET `acceptance_status`='1',`tbl_user_idtbl_user`='$userID' WHERE `idtbl_return`='$record'";
if($conn->query($sql)==true){
    if($type == 1){
        header("Location:../customerreturn.php?action=6");

    }else if($type == 2){
        header("Location:../supplierreturn.php?action=6");

    }else if($type == 3){
        header("Location:../damagereturns.php?action=6");

    }

}
else{
    if($type == 1){
        header("Location:../customerreturn.php?action=5");

    }else if($type == 2){
        header("Location:../supplierreturn.php?action=5");

    }else if($type == 3){
        header("Location:../damagereturns.php?action=5");

    }
}
?>