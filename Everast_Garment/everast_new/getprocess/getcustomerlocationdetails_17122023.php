<?php
require_once('../connection/db.php');

$record=$_POST['customerID'];

$sql="SELECT `address`, `phone` FROM `tbl_customer` WHERE `idtbl_customer`='$record'";
$result=$conn->query($sql);
$row=$result->fetch_assoc();


$obj=new stdClass();

$obj->phone=$row['phone'];
$obj->address=$row['address'];

echo json_encode($obj);
?>