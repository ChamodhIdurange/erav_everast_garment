<?php
require_once('../connection/db.php');

$userid = $_POST['userid'];
$usertype = $_POST['usertype'];
$userlocation = $_POST['userlocation'];

$arraylist=array();
$sql = "SELECT * FROM `tbl_locations`";

if($usertype == 1 || $usertype == 2){
    $sql = "SELECT * FROM `tbl_locations`";
}else if($usertype == 3){
    $sql = "SELECT * FROM `tbl_locations` WHERE `idtbl_locations` = '$userlocation'";
}
$result=$conn->query($sql);

while($rowlist=$result->fetch_assoc()){
    $obj=new stdClass();
    $obj->locationid=$rowlist['idtbl_locations'];
    $obj->location=$rowlist['locationname'];
    
    array_push($arraylist, $obj);
}

echo json_encode($arraylist);

?>