<?php
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('../connection/db.php');//die('bc');
$userID=$_SESSION['userid'];


$orderid=$_POST['orderid'];
$trackingurl=$_POST['trackingurl'];
$trackingcode=$_POST['trackingcode'];
$updatedatetime=date('Y-m-d h:i:s');

    $update="UPDATE `tbl_porder` SET `trackingno`='$trackingcode',`trackingwebsite`='$trackingurl', `updatedatetime`='$updatedatetime', `tbl_user_idtbl_user` = '$userID' WHERE `idtbl_porder`='$orderid'";
    if($conn->query($update)==true){
        header("Location:../customerporder.php?action=4");
        // print_r("success");
    }else{
        header("Location:../customerporder.php?action=5");
        // print_r("error");

    }

?>