<?php
require_once('../connection/db.php');

$record=$_POST['recordID'];

$sql="SELECT SUM(`qty`) AS `totqty` FROM `tbl_stock`  WHERE `tbl_product_idtbl_product`='$record' GROUP BY `tbl_product_idtbl_product`";
$result=$conn->query($sql);
$row=$result->fetch_assoc();

$sqlaverage="SELECT AVG(`unitprice`) AS `avgunitprice`, AVG(`saleprice`) AS `avgsaleprice` FROM `tbl_grndetail`  WHERE `tbl_product_idtbl_product`='$record' GROUP BY `tbl_product_idtbl_product`";
$resultavg=$conn->query($sqlaverage);
$rowavg=$resultavg->fetch_assoc();

$sqllastpurchase="SELECT `unitprice`, `date` FROM `tbl_grndetail` WHERE `tbl_product_idtbl_product` = '$record' ORDER BY `idtbl_grndetail` DESC LIMIT 1";
$resultlastpurchase=$conn->query($sqllastpurchase);
$rowlastpurchase=$resultlastpurchase->fetch_assoc();

$obj=new stdClass();
$obj->totqty=$row['totqty'];
$obj->avgunitprice=$rowavg['avgunitprice'];
$obj->avgsaleprice=$rowavg['avgsaleprice'];
$obj->lastunitprice=$rowlastpurchase['unitprice'];
$obj->lastdate=$rowlastpurchase['date'];


echo json_encode($obj);
?>