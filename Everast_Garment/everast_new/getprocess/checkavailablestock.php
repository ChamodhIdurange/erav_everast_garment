<?php 
require_once('../connection/db.php');

$productID=$_POST['productID'];

$sqlstock="SELECT SUM(`qty`) as `qty` FROM `tbl_stock` WHERE `tbl_product_idtbl_product`='$productID' GROUP BY `tbl_product_idtbl_product`";
$result=$conn->query($sqlstock);
$row=$result->fetch_assoc();
$stockqty = $row['qty'];


$sqlholdstock="SELECT SUM(`qty`) as `qty` FROM `tbl_customer_order_hold_stock` WHERE `tbl_product_idtbl_product`='$productID' AND `invoiceissue` = '0' GROUP BY `tbl_product_idtbl_product`";
$result=$conn->query($sqlholdstock);
$row=$result->fetch_assoc();

$holdqty = $row['qty'];

$obj=new stdClass();
$obj->availableqty=$stockqty - $holdqty;
$obj->stockqty=$stockqty;
$obj->holdqty=$holdqty;

echo json_encode($obj);
?>