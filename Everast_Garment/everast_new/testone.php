<?php
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('connection/db.php');//die('bc');
$userID=$_SESSION['userid'];

$sql="SELECT * from `tbl_product`";
$updatedatetime=date('Y-m-d h:i:s');

$result =$conn-> query($sql); 
while ($row = $result-> fetch_assoc()) {
    $id = $row['idtbl_product'];
    $sql1="INSERT INTO `tbl_stock` (`qty`, `update`, `status`, `updatedatetime`, `tbl_user_idtbl_user`,`tbl_product_idtbl_product`) Values ('0','$updatedatetime','1','$updatedatetime','$userID','$id')";
    $result1 =$conn-> query($sql1); 
}
?>