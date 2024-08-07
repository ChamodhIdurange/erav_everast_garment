<?php 
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('../connection/db.php');

$userID=$_SESSION['userid'];

$poID=$_POST['poID'];
$total=$_POST['total'];
$nettotal=$_POST['nettotal'];
$discount=$_POST['discount'];
$acceptanceType=$_POST['acceptanceType'];
$tableData=$_POST['tableData'];
$updatedatetime=date('Y-m-d h:i:s');
$areaId=null;
$locationId=null;
$customerId=null;

if($acceptanceType == 1){
    $updatePoStatus="UPDATE  `tbl_customer_order` SET `confirm`='1', `discount`='$discount', `nettotal`='$nettotal', `total`='$total', `confrimuser`='$userID' WHERE `idtbl_customer_order`='$poID'";
}else if($acceptanceType == 2){
    $updatePoStatus="UPDATE  `tbl_customer_order` SET `dispatchissue`='1', `discount`='$discount',`nettotal`='$nettotal', `total`='$total', `dispatchuser`='$userID' WHERE `idtbl_customer_order`='$poID'";

    $insertDispatch="INSERT INTO `tbl_cutomer_order_dispatch`(`dispatchdate`, `vehicleno`, `drivername`, `trackingno`, `trackingwebsite`, `currier`, `status`, `insertdatetime`, `tbl_user_idtbl_user`) VALUES('$updatedatetime', '-', '-', '-', '-', '-', '1', '$updatedatetime', '$userID')";
    $conn->query($insertDispatch);
    $dispatchId = $conn->insert_id;
            
    $insertDispatchInfo="INSERT INTO `tbl_cutomer_order_dispatch_has_tbl_customer_order`(`tbl_cutomer_order_dispatch_idtbl_cutomer_order_dispatch`, `tbl_customer_order_idtbl_customer_order`) VALUES('$dispatchId', '$poID')";
    $conn->query($insertDispatchInfo);
}else if($acceptanceType == 3){
    $updatePoStatus="UPDATE  `tbl_customer_order` SET `delivered`='1', `ship`='1', `discount`='$discount',`nettotal`='$nettotal', `total`='$total', `delivereduser`='$userID', `shipuser`='$userID' WHERE `idtbl_customer_order`='$poID'";

    $getporderdata = "SELECT * FROM `tbl_customer_order` WHERE `idtbl_customer_order` = '$poID'";
    $result = $conn->query($getporderdata);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $areaId = $row['tbl_area_idtbl_area'];
        $locationId = $row['tbl_locations_idtbl_locations'];
        $customerId = $row['tbl_customer_idtbl_customer'];

        $insertInvoice="INSERT INTO `tbl_invoice`(`invoiceno`, `date`, `total`, `discount`, `vatamount`, `nettotal`, `paymentcomplete`, `status`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_area_idtbl_area`, `tbl_customer_idtbl_customer`, `tbl_locations_idtbl_locations`, `tbl_customer_order_idtbl_customer_order`) VALUES('-', '$updatedatetime', '$total', '$discount', '0', '$nettotal', '0', '1', '$updatedatetime', '$userID', '$areaId', '$customerId', '$locationId', '$userID')";
        $conn->query($insertInvoice);

        $invoiceId = $conn->insert_id;
    } 
}

if($conn->query($updatePoStatus)==true){

    foreach($tableData as $rowtabledata){
        $productID=$rowtabledata['col_2'];
        $podetailId=$rowtabledata['col_3'];
        $qty=$rowtabledata['col_4'];

        if($acceptanceType == 1){
            $updatePoDetail="UPDATE  `tbl_customer_order_detail` SET `confirmqty`='$qty' WHERE `idtbl_customer_order_detail` = '$podetailId'";

            $updateHoldStock="UPDATE  `tbl_customer_order_hold_stock` SET `qty`='$qty' WHERE `tbl_product_idtbl_product` = '$productID' AND `tbl_customer_order_idtbl_customer_order` = '$poID'";
        }else if($acceptanceType == 2){
            $updatePoDetail="UPDATE  `tbl_customer_order_detail` SET `dispatchqty`='$qty' WHERE `idtbl_customer_order_detail` = '$podetailId'";

            $updateHoldStock="UPDATE  `tbl_customer_order_hold_stock` SET `qty`='$qty' WHERE `tbl_product_idtbl_product` = '$productID' AND `tbl_customer_order_idtbl_customer_order` = '$poID'";
        }else if($acceptanceType == 3){
            $updatePoDetail="UPDATE  `tbl_customer_order_detail` SET `qty`='$qty' WHERE `idtbl_customer_order_detail` = '$podetailId'";

            $updateHoldStock="UPDATE  `tbl_customer_order_hold_stock` SET `qty`='$qty' WHERE `tbl_product_idtbl_product` = '$productID' AND `tbl_customer_order_idtbl_customer_order` = '$poID'";

            $getporderdata = "SELECT * FROM `tbl_customer_order_detail` WHERE `idtbl_customer_order_detail` = '$podetailId'";
            $result = $conn->query($getporderdata);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $unitprice = $row['unitprice'];
                $saleprice = $row['saleprice'];
                $total = $row['total'];
                $discount = $row['discount'];

                $insertInvoideDetail="INSERT INTO `tbl_invoice_detail`(`qty`, `unitprice`, `saleprice`, `discount`, `total`, `status`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_product_idtbl_product`, `tbl_invoice_idtbl_invoice`) VALUES('$qty', '$unitprice', '$saleprice', '$discount', '$total', '1', '$updatedatetime', '$userID', '$productID', '$invoiceId')";
                $conn->query($insertInvoideDetail);

                $month = date('m');

                $invoiceNo = 'IV/'.$month.'/'.$invoiceId;

                $updateInvoiceNo="UPDATE `tbl_invoice` SET `invoiceno`='$invoiceNo' WHERE `idtbl_invoice` = '$invoiceId'";
                $conn->query($updateInvoiceNo);
            } 

            
        }

        $conn->query($updatePoDetail);
        $conn->query($updateHoldStock);

    }
        
    $actionObj=new stdClass();
    $actionObj->icon='fas fa-check-circle';
    $actionObj->title='';
    $actionObj->message='Record Updated Successfully';
    $actionObj->url='';
    $actionObj->target='_blank';
    $actionObj->type='success';

    echo $actionJSON=json_encode($actionObj);
}else{
    $actionObj=new stdClass();
    $actionObj->icon='fas fa-exclamation-triangle';
    $actionObj->title='';
    $actionObj->message='Record Error';
    $actionObj->url='';
    $actionObj->target='_blank';
    $actionObj->type='danger';

    echo $actionJSON=json_encode($actionObj);
}