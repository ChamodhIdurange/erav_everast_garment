<?php 
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('../connection/db.php');
$userID=$_SESSION['userid'];

$recordOption=$_POST['recordOption'];
if(!empty($_POST['recordID'])){$recordID=$_POST['recordID'];}
$issueproduct=$_POST['issueproduct'];
$freeproduct=$_POST['freeproduct'];
$issueqty=$_POST['issueqty'];
$freeqty=$_POST['freeqty'];
$updatedatetime=date('Y-m-d h:i:s');

if($recordOption==1){
    $insert="INSERT INTO `tbl_product_free`(`qtycount`, `freecount`, `status`, `updatedatetime`, `tbl_user_idtbl_user`, `issueproductid`, `freeproductid`) VALUES ('$issueqty','$freeqty','1','$updatedatetime','$userID','$issueproduct','$freeproduct')";
    if($conn->query($insert)==true){        
        header("Location:../productfree.php?action=4");
    }
    else{header("Location:../productfree.php?action=5");}
}
else{
    $update="UPDATE `tbl_product_free` SET `qtycount`='$issueqty',`freecount`='$freeqty',`updatedatetime`='$updatedatetime',`tbl_user_idtbl_user`='$userID',`issueproductid`='$issueproduct',`freeproductid`='$freeproduct' WHERE `idtbl_product_free`='$recordID'";
    if($conn->query($update)==true){     
        header("Location:../productfree.php?action=6");
    }
    else{header("Location:../productfree.php?action=5");}
}
?>