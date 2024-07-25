<?php
require_once('../connection/db.php');

$orderID=$_POST['orderID'];

$sqlorderdetail="SELECT `u`.*, `ua`.`product_name` AS `issueproduct` FROM `tbl_customer_order_detail` AS `u` LEFT JOIN `tbl_product` AS `ua` ON `ua`.`idtbl_product`=`u`.`tbl_product_idtbl_product` WHERE `u`.`status`=1 AND `u`.`tbl_customer_order_idtbl_customer_order`='$orderID'";
$resultorderdetail=$conn->query($sqlorderdetail);

$sqlorder="SELECT `p`.`total`, `p`.`confirm`, `p`.`dispatchissue`, `p`.`delivered`, `p`.`discount`, `p`.`podiscount`, `p`.`nettotal`, `p`.`remark`, `c`.`name`, `c`.`phone` FROM `tbl_customer_order` as `p`  JOIN `tbl_customer` AS `c` ON (`c`.`idtbl_customer` = `p`.`tbl_customer_idtbl_customer`) WHERE `p`.`idtbl_customer_order`='$orderID'";
$resultorder=$conn->query($sqlorder);
$roworder=$resultorder->fetch_assoc();

$detailarray=array();
while($roworderdetail=$resultorderdetail->fetch_assoc()){
    $totnew=$roworderdetail['qty']*$roworderdetail['saleprice'];
    $total=number_format(($totnew), 2);

    $objdetail=new stdClass();
    $objdetail->productname=$roworderdetail['issueproduct'];
    $objdetail->productid=$roworderdetail['tbl_product_idtbl_product'];
    $objdetail->unitprice=$roworderdetail['saleprice'];
    $objdetail->orderqty=$roworderdetail['orderqty'];
    $objdetail->confirmqty=$roworderdetail['confirmqty'];
    $objdetail->dispatchqty=$roworderdetail['dispatchqty'];
    $objdetail->qty=$roworderdetail['qty'];
    $objdetail->podetailid=$roworderdetail['idtbl_customer_order_detail'];

    $objdetail->total=$total;

    array_push($detailarray, $objdetail);
}

$obj=new stdClass();
$obj->remark=$roworder['remark'];
$obj->cusname=$roworder['name'];
$obj->cuscontact=$roworder['phone'];
$obj->confirm=$roworder['confirm'];
$obj->dispatchissue=$roworder['dispatchissue'];
$obj->delivered=$roworder['delivered'];
$obj->nettotalshow=number_format($roworder['nettotal'], 2);
$obj->subtotal=number_format($roworder['total'], 2);
$obj->disamount=number_format($roworder['discount'], 2);
$obj->po_amount=number_format($roworder['podiscount'], 2);
$obj->nettotal=$roworder['nettotal'];
$obj->tablelist=$detailarray;

echo json_encode($obj);

?>