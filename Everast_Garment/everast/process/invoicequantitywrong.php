<?php
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('../connection/db.php');//die('bc');
$userID=$_SESSION['userid'];

$qtyreason = $_POST['qtyreason'];
$recordID = $_POST['hiddenid'];
$qtycheckratio=$_POST['qtycheckratio'];

if(!empty($_POST['qtyreason'])){$qtyreason=$_POST['qtyreason'];}

header("Location:../offer.php?action=4");
$updatedatetime=date('Y-m-d h:i:s');

    if($qtycheckratio == 2){
        $update="UPDATE `tbl_invoice` SET `qtycancelstatus`='$qtycheckratio',`qty_updatedatetime`='$updatedatetime',`qty_checked_user`='$userID',`qtyreason`='$qtyreason' WHERE `idtbl_invoice`='$recordID'";
    }else if($qtycheckratio == 1){
        $update="UPDATE `tbl_invoice` SET `qtycancelstatus`='$qtycheckratio',`qty_updatedatetime`='$updatedatetime', `qtyreason`='Quantity is correct', `qty_checked_user`='$userID' WHERE `idtbl_invoice`='$recordID'";

    }
    if($conn->query($update)==true){
 
        header("Location:../invoiceview.php?action=4");
    }else{
        header("Location:../invoiceview.php?action=5");
    }

?>
