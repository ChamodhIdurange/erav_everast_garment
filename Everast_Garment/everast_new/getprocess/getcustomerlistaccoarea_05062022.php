<?php 
require_once('../connection/db.php');

$areaID=$_POST['areaID'];

$sql="SELECT `idtbl_customer`, `name` FROM `tbl_customer` WHERE `status`=1 AND `tbl_area_idtbl_area`='$areaID'";
$result=$conn->query($sql);

$arraylist=array();
while($row=$result->fetch_assoc()){
    $obj=new stdClass();
    $obj->id=$row['idtbl_customer'];
    $obj->name=$row['name'];
    
    array_push($arraylist, $obj);
}

echo json_encode($arraylist);
?>