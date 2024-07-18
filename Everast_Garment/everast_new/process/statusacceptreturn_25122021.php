<?php 
session_start();
if(!isset($_SESSION['userid'])){header ("Location:../index.php");}
require_once('../connection/db.php'); 

$userID=$_SESSION['userid'];
$record=$_GET['record'];
$type=$_GET['type'];

$sqlReturn = "SELECT `qty`,`tbl_product_idtbl_product` FROM `tbl_return` WHERE `idtbl_return` = '$record'";
$resultReturn=$conn->query($sqlReturn);
$rowReturn = $resultReturn-> fetch_assoc();
$prodictID =  $rowReturn['tbl_product_idtbl_product'];
$qty =  $rowReturn['qty'];


$sql="UPDATE `tbl_return` SET `acceptance_status`='1',`tbl_user_idtbl_user`='$userID' WHERE `idtbl_return`='$record'";
if($conn->query($sql)==true){
    if($type == 1){
        $updatestock="UPDATE `tbl_stock` SET `qty`=(`qty`+'$qty') WHERE `tbl_product_idtbl_product`='$prodictID'";
            if($conn->query($updatestock)==true){
                header("Location:../productreturn.php?action=6");
            }else{header("Location:../productreturn.php?action=5");}
    }else if($type == 2){
        $updatestock="UPDATE `tbl_stock` SET `qty`=(`qty`-'$qty') WHERE `tbl_product_idtbl_product`='$prodictID'";
        if($conn->query($updatestock)==true){
            header("Location:../productreturn.php?action=6");
        }else{header("Location:../productreturn.php?action=5");}
    }else{
        header("Location:../productreturn.php?action=6");
    }

}
else{
    header("Location:../productreturn.php?action=5");
}
?>