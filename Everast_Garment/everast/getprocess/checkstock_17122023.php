<?php 
require_once('../connection/db.php');

$productid=$_POST['productid'];
$locationid=$_POST['locationid'];

$sql="SELECT * FROM `tbl_stock` WHERE `tbl_product_idtbl_product`='$productid'";
$result=$conn->query($sql);
$row=$result->fetch_assoc();

$obj=new stdClass();
$obj->qty=$row['qty'];

echo json_encode($obj);
?>