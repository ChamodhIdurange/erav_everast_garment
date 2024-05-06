<?php 
require_once('../connection/db.php');

$productID=$_POST['productID'];
$repID=$_POST['repID'];
$orderdate= strtotime($_POST['orderdate']);

$month = date('m', $orderdate);

$sql="SELECT COUNT(`idtbl_employee_target`) AS `count` FROM `tbl_employee_target` WHERE MONTH(`month`)='$month' AND `status`=1 AND `tbl_employee_idtbl_employee`='$repID' AND `tbl_product_idtbl_product`='$productID'";
$result=$conn->query($sql);
$row=$result->fetch_assoc();

$obj=new stdClass();
$obj->count=$row['count'];

echo json_encode($obj);
?>