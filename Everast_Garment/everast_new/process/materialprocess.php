<?php 
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('../connection/db.php');

$userID=$_SESSION['userid'];

$recordOption=$_POST['recordOption'];
if(!empty($_POST['recordID'])){$recordID=$_POST['recordID'];}
$materialname=$_POST['materialname'];
$barcode=$_POST['barcode'];
$unitprice=$_POST['unitprice'];
$saleprice=$_POST['saleprice'];
$reorderlevel=$_POST['reorderlevel'];
$retailprice=$_POST['retailprice'];
$retaildiscount=$_POST['retaildiscount'];


$updatedatetime=date('Y-m-d h:i:s');

if($recordOption==1){
    $insertmaterial="INSERT INTO `tbl_material`(`materialname`, `materialbarcode`, `unitprice`, `saleprice`, `reorderlevel`, `retail`, `retaildiscount`, `status`, `insertdatetime`,`tbl_user_idtbl_user`) VALUES ('$materialname','$barcode','$unitprice','$saleprice','$reorderlevel', '$retailprice', '$retaildiscount', '1', '$updatedatetime', '$userID')";
    if($conn->query($insertmaterial)==true){ 
        header("Location:../materials.php?action=4");
    }   
}
else{
   
    $update="UPDATE `tbl_material` SET `materialname`='$materialname',`materialbarcode`='$barcode',`unitprice`='$unitprice', `saleprice`='$saleprice', `reorderlevel`='$reorderlevel', `retail`='$retailprice', `retaildiscount`='$retaildiscount', `updatedatetime`='$updatedatetime', `tbl_user_idtbl_user` = '$userID' WHERE `idtbl_material`='$recordID'";

    if($conn->query($update)==true){    
        header("Location:../materials.php?action=6");
    }
    else{header("Location:../materials.php?action=5");}
}
?>