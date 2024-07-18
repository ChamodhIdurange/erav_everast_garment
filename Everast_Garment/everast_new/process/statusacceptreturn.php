<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location:../index.php");
}
require_once('../connection/db.php');

$userID = $_SESSION['userid'];
$record = $_GET['record'];
// $type=$_GET['type'];
$updateqty = 0;
$sqlReturn = "SELECT `returntype` FROM `tbl_return` WHERE `idtbl_return` = '$record'";
$resultReturn = $conn->query($sqlReturn);
$rowReturn = $resultReturn->fetch_assoc();
$type =  $rowReturn['returntype'];
$sqlgetqty = "SELECT `qty`, `tbl_product_idtbl_product` FROM `tbl_return_details` WHERE `tbl_return_idtbl_return` = '$record'";
$resultsqlgetqty = $conn->query($sqlgetqty);

$sql = "UPDATE `tbl_return` SET `acceptance_status`='1',`tbl_user_idtbl_user`='$userID' WHERE `idtbl_return`='$record'";
if ($conn->query($sql) == true) {
    if ($type == 1) {

        if ($resultsqlgetqty->num_rows > 0) {
            while ($row = $resultsqlgetqty->fetch_assoc()) {
                $qty = $row['qty'];
                $tbl_product_idtbl_product = $row['tbl_product_idtbl_product'];

                $sqlgetstockqty = "SELECT `qty` FROM `tbl_stock` WHERE `tbl_product_idtbl_product` = ' $tbl_product_idtbl_product'";
                $resultsqlgetstockqty = $conn->query($sqlgetstockqty);
                while ($row = $resultsqlgetstockqty->fetch_assoc()) {
                    $stockqty = $row['qty']; 
                }
                $updateqty = $stockqty + $qty;
            }
            $sqlupdate = "UPDATE `tbl_stock` SET `qty`='$updateqty' WHERE `tbl_product_idtbl_product`='$tbl_product_idtbl_product'";
             $conn->query($sqlupdate);
        }
        if ($conn->query($sql) == true) {
            header("Location:../customerreturn.php?action=6");
        }
    } else if ($type == 2) {
        header("Location:../supplierreturn.php?action=6");
    } else if ($type == 3) {
        header("Location:../damagereturns.php?action=6");
    }
} else {
    if ($type == 1) {
        header("Location:../customerreturn.php?action=5");
    } else if ($type == 2) {
        header("Location:../supplierreturn.php?action=5");
    } else if ($type == 3) {
        header("Location:../damagereturns.php?action=5");
    }
}
