<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location:../index.php");
}
require_once('../connection/db.php');

$userID = $_SESSION['userid'];
$record = $_GET['record'];
$type = $_GET['type'];

$updatedatetime=date('Y-m-d h:i:s');

$currdate=date('Y-m-d');



$sql = "SELECT  g.batchno, gd.qty, gd.tbl_product_idtbl_product FROM  tbl_grn g JOIN  tbl_grndetail gd ON g.idtbl_grn = gd.tbl_grn_idtbl_grn WHERE  g.idtbl_grn = '$record'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $insert_stock = "INSERT INTO tbl_stock (batchqty, qty, `update`, status, batchno, insertdatetime, tbl_user_idtbl_user, tbl_product_idtbl_product) 
                         VALUES ('{$row['qty']}', '{$row['qty']}', '$currdate', '1', '{$row['batchno']}', NOW(), '$userID', '{$row['tbl_product_idtbl_product']}')";

        if (!$conn->query($insert_stock)) {
            header("Location:../grn.php?action=5");
            exit();
        }
    }

    $update_grn = "UPDATE tbl_grn SET transferstatus = 1, tbl_user_idtbl_user = '$userID' WHERE idtbl_grn = '$record'";

    if ($conn->query($update_grn) === true) {
        header("Location:../grn.php?action=$type");
    } else {
        header("Location:../grn.php?action=5");
    }
} else {
    header("Location:../grn.php?action=5");
}
?>
