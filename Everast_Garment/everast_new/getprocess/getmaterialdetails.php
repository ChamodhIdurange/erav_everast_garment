<?php 
require_once('../connection/db.php');


$record=$_POST['recordID'];

$sql="SELECT * FROM `tbl_material` WHERE `idtbl_material`='$record'";
$result=$conn->query($sql);
$row=$result->fetch_assoc();

$obj=new stdClass();
$obj->id=$row['idtbl_material'];
$obj->materialname=$row['materialname'];
$obj->materialbarcode=$row['materialbarcode'];
$obj->unitprice=$row['unitprice'];
$obj->saleprice=$row['saleprice'];
$obj->reorderlevel=$row['reorderlevel'];
$obj->retail=$row['retail'];
$obj->retaildiscount=$row['retaildiscount'];

echo json_encode($obj);
?>