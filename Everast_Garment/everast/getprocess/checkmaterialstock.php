<?php 
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('../connection/db.php');
$userID=$_SESSION['userid'];

$materialid=$_POST['materialid'];
$requiredqty=$_POST['requiredqty'];

$checkstock="SELECT SUM(`qty`) AS `qty` FROM `tbl_material_stock` WHERE `status` = '1' AND `tbl_material_idtbl_material` = '$materialid' GROUP BY `tbl_material_idtbl_material` HAVING SUM(`qty`) > '$requiredqty'";
$result =$conn-> query($checkstock); 
$row = $result-> fetch_assoc();

$obj=new stdClass();
$obj->qty=$row['qty'];

echo json_encode($obj);

?>