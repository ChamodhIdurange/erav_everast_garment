<?php 
require_once('../connection/db.php');

$record=$_POST['recordID'];

$sql="SELECT * FROM `tbl_freeissue_type` WHERE `idtbl_freeissue_type`='$record'";
$result=$conn->query($sql);
$row=$result->fetch_assoc();

$obj=new stdClass();
$obj->id=$row['idtbl_freeissue_type'];
$obj->category=$row['type'];

echo json_encode($obj);
?>