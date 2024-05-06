<?php
require_once('../connection/db.php');
$productid = $_POST['productID'];

$sql = "SELECT `m`.`materialname`, `m`.`idtbl_material`, `pm`.`qty`, `pm`.`idtbl_product_materials` FROM `tbl_material` AS `m` JOIN `tbl_product_materials` AS `pm` ON (`m`.`idtbl_material` = `pm`.`tbl_material_idtbl_material`) WHERE `pm`.`status`=1 AND `pm`.`tbl_product_idtbl_product` = '$productid'";
$result = $conn->query($sql);

$arraylist=array();
while($row=$result->fetch_assoc()){
    $obj=new stdClass();
    $obj->materialid=$row['idtbl_material'];
    $obj->materialname=$row['materialname'];
    $obj->requiredqty=$row['qty'];
    
    array_push($arraylist, $obj);
}

echo json_encode($arraylist);

?>