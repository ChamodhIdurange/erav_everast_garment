<?php 
require_once('../connection/db.php');

$record=$_POST['recordID'];

$sql="SELECT * FROM `tbl_electrician` WHERE `idtbl_electrician`='$record'";
$result=$conn->query($sql);
$row=$result->fetch_assoc();

$obj=new stdClass();
$obj->id=$row['idtbl_electrician'];
$obj->name=$row['name'];
$obj->area=$row['tbl_area_idtbl_area'];
$obj->customer=$row['tbl_customer_idtbl_customer'];
$obj->contact=$row['contact'];

echo json_encode($obj);
?>