<?php
require_once('../connection/db.php');

$orderID=$_POST['orderID'];

$sqlorder="SELECT `nettotal`, `remark`, `ismaterialpo` FROM `tbl_porder` WHERE `idtbl_porder`='$orderID'";
$resultorder=$conn->query($sqlorder);
$roworder=$resultorder->fetch_assoc();

$detailarray=array();
if($roworder['ismaterialpo'] == 0){
    $sqlorderdetail="SELECT * FROM `tbl_porder_detail` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_porder_detail`.`tbl_product_idtbl_product` WHERE `tbl_porder_detail`.`status`=1 AND `tbl_porder_detail`.`tbl_porder_idtbl_porder`='$orderID'";
    $resultorderdetail=$conn->query($sqlorderdetail);

    while($roworderdetail=$resultorderdetail->fetch_assoc()){
        $totnew=$roworderdetail['qty']*$roworderdetail['unitprice'];
        $total=number_format(($totnew), 2);
    
        $objdetail=new stdClass();
        $objdetail->productname=$roworderdetail['product_name'];
        $objdetail->productid=$roworderdetail['tbl_product_idtbl_product'];
        $objdetail->unitprice=number_format($roworderdetail['unitprice'], 2);
        $objdetail->newqty=$roworderdetail['qty'];
        $objdetail->total=$total;
    
        array_push($detailarray, $objdetail);
    }
}else{
    $sqlorderdetail="SELECT * FROM `tbl_porder_detail` LEFT JOIN `tbl_material` ON `tbl_material`.`idtbl_material`=`tbl_porder_detail`.`tbl_material_idtbl_material` WHERE `tbl_porder_detail`.`status`=1 AND `tbl_porder_detail`.`tbl_porder_idtbl_porder`='$orderID'";
    $resultorderdetail=$conn->query($sqlorderdetail);
    
    while($roworderdetail=$resultorderdetail->fetch_assoc()){
        $totnew=$roworderdetail['qty']*$roworderdetail['unitprice'];
        $total=number_format(($totnew), 2);
    
        $objdetail=new stdClass();
        $objdetail->productname=$roworderdetail['materialname'];
        $objdetail->productid=$roworderdetail['idtbl_material'];
        $objdetail->unitprice=number_format($roworderdetail['unitprice'], 2);
        $objdetail->newqty=$roworderdetail['qty'];
        $objdetail->total=$total;

        array_push($detailarray, $objdetail);
    }

}

$obj=new stdClass();
$obj->remark=$roworder['remark'];
$obj->nettotalshow=number_format($roworder['nettotal'], 2);
$obj->nettotal=$roworder['nettotal'];
$obj->tablelist=$detailarray;

echo json_encode($obj);

?>