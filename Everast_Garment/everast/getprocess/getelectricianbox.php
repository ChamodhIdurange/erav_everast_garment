<?php
require_once('../connection/db.php');

$record=$_POST['recordID'];

$sql="SELECT * FROM `tbl_electrician_box` WHERE `idtbl_electrician_box`='$record'";
$result=$conn->query($sql);
$row=$result->fetch_assoc();

$obj=new stdClass();
$obj->id=$row['idtbl_electrician_box'];
$obj->quantity=$row['quantity'];
$obj->totalstarpoints=$row['totalstarpoints'];
$obj->product=$row['tbl_product_idtbl_product'];
$obj->electrician=$row['tbl_electrician_idtbl_electrician'];
$obj->recieveddate=$row['recieveddate'];

echo json_encode($obj);
?>