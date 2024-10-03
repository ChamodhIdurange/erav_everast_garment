<?php 
session_start();
require_once('../connection/db.php');//die('bc');
$userID=$_POST['userID'];

$orderdate=$_POST['orderdate'];
$remark=$_POST['remark'];
$discountpresentage=$_POST['discountpresentage'];
$total=$_POST['total'];
$discount=$_POST['discount'];
$nettotal=$_POST['nettotal'];
$repname=$_POST['repname'];
$area=$_POST['area'];
$customer=$_POST['customer'];
$location=$_POST['locationID'];
$podiscount=$_POST['podiscount'];
$paymentoption=1;
$tableData=$_POST['tableData'];
$tableData = json_decode($tableData);

$updatedatetime=date('Y-m-d h:i:s');


$month=date('n');


$insretorder = "INSERT INTO `tbl_customer_order`(`date`, `total`, `discount`, `podiscount`, `vat`, `nettotal`, `remark`, `vatpre`, `status`, `insertdatetime`, `tbl_user_idtbl_user`, `tbl_area_idtbl_area`, `tbl_employee_idtbl_employee`, `tbl_locations_idtbl_locations`, `tbl_customer_idtbl_customer`) VALUES ('$orderdate','$total','$discount', '$podiscount', '0', '$nettotal', '$remark', '0','1', '$updatedatetime', '$userID', '$area', '$repname', '$location' , '$customer')";

    if ($conn->query($insretorder) == true) {
        $orderID = $conn->insert_id;

        foreach ($tableData as $item) {
            $productID=$item->productID;
            $product=0;
            $unitprice=$item->unitprice;;
            $saleprice=$item->saleprice;
            $newqty=$item->newqty;
            $freeprodcutid=0;
            $freeqty=0;
            $total==$item->total;

            $insertorderdetail = "INSERT INTO `tbl_customer_order_detail`(`orderqty`, `total`, `confirmqty`, `dispatchqty`, `qty`, `unitprice`, `saleprice`, `discountpresent`, `discount`, `status`, `insertdatetime`, `tbl_user_idtbl_user`, `tbl_customer_order_idtbl_customer_order`, `tbl_product_idtbl_product`) VALUES ('$newqty', '$total', '$newqty', '$newqty', '$newqty', '$unitprice','$saleprice', '0', '0', '1','$updatedatetime','$userID','$orderID','$productID')";
            $conn->query($insertorderdetail);

            $insertholdstock = "INSERT INTO `tbl_customer_order_hold_stock`(`qty`, `invoiceissue`, `status`, `insertdatetime`, `tbl_user_idtbl_user`, `tbl_product_idtbl_product`, `tbl_customer_order_idtbl_customer_order`) VALUES ('$newqty', '0', '1', '$updatedatetime', '$userID', '$productID','$orderID')";
            $conn->query($insertholdstock);
        }

        $actionObj=new stdClass();
        $actionObj->code='200';
        $actionObj->message='Addedd Successfully';
    
        echo json_encode($actionObj);
    } else {
        echo $actionJSON='Something went wrong';

    }


