<?php
require_once('../connection/db.php');

$orderID=$_POST['orderID'];

$sqlorderdetail="SELECT `u`.*, `ua`.`product_name` AS `issueproduct`, `ub`.`product_name` AS `freeproduct` FROM `tbl_porder_detail` AS `u` LEFT JOIN `tbl_product` AS `ua` ON `ua`.`idtbl_product`=`u`.`tbl_product_idtbl_product` LEFT JOIN `tbl_product` AS `ub` ON `ub`.`idtbl_product`=`u`.`freeproductid` WHERE `u`.`status`=1 AND `u`.`tbl_porder_idtbl_porder`='$orderID'";
$resultorderdetail=$conn->query($sqlorderdetail);

$sqlorder="SELECT `subtotal`,`disamount`,`nettotal`, `remark` FROM `tbl_porder` WHERE `idtbl_porder`='$orderID'";
$resultorder=$conn->query($sqlorder);
$roworder=$resultorder->fetch_assoc();

$detailarray=array();
while($roworderdetail=$resultorderdetail->fetch_assoc()){
    $totnew=$roworderdetail['qty']*$roworderdetail['saleprice'];
    $total=number_format(($totnew), 2);

    $objdetail=new stdClass();
    $objdetail->productname=$roworderdetail['issueproduct'];
    $objdetail->productid=$roworderdetail['tbl_product_idtbl_product'];
    $objdetail->unitprice=number_format($roworderdetail['saleprice'], 2);
    $objdetail->newqty=$roworderdetail['qty'];
    if(!empty($roworderdetail['freeproduct'])){$objdetail->freeproduct=$roworderdetail['freeproduct'];}
    else{$objdetail->freeproduct='';}
    $objdetail->freeproductid=$roworderdetail['freeproductid'];
    $objdetail->freeqty=$roworderdetail['freeqty'];
    $objdetail->total=$total;

    array_push($detailarray, $objdetail);
}

$obj=new stdClass();
$obj->remark=$roworder['remark'];
$obj->nettotalshow=number_format($roworder['nettotal'], 2);
$obj->subtotal=number_format($roworder['subtotal'], 2);
$obj->disamount=number_format($roworder['disamount'], 2);
$obj->nettotal=$roworder['nettotal'];
$obj->tablelist=$detailarray;

echo json_encode($obj);

?>