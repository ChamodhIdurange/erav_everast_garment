<?php 
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('../connection/db.php');

$userID=$_SESSION['userid'];

$poID=$_POST['poID'];
$total=$_POST['total'];
$nettotal=$_POST['nettotal'];
$discount=$_POST['discount'];
$podiscountPrecentage=$_POST['podiscountPrecentage'];
$podiscountAmount=$_POST['podiscountAmount'];

$acceptanceType=$_POST['acceptanceType'];
$tableData=$_POST['tableData'];
$updatedatetime=date('Y-m-d h:i:s');
$areaId=null;
$locationId=null;
$customerId=null;

$fullDiscount = $discount + $podiscountAmount;

if($acceptanceType == 1){
    $updatePoStatus="UPDATE  `tbl_customer_order` SET `confirm`='1', `podiscount`='$podiscountAmount', `podiscountpercentage`='$podiscountPrecentage', `discount`='$discount', `nettotal`='$nettotal', `total`='$total', `confrimuser`='$userID' WHERE `idtbl_customer_order`='$poID'";

    $getporderdata = "SELECT * FROM `tbl_customer_order` WHERE `idtbl_customer_order` = '$poID'";
    $result = $conn->query($getporderdata);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $areaId = $row['tbl_area_idtbl_area'];
        $locationId = $row['tbl_locations_idtbl_locations'];
        $customerId = $row['tbl_customer_idtbl_customer'];

        $insertInvoice="INSERT INTO `tbl_invoice`(`invoiceno`, `date`, `total`, `discount`, `vatamount`, `nettotal`, `paymentcomplete`, `status`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_area_idtbl_area`, `tbl_customer_idtbl_customer`, `tbl_locations_idtbl_locations`, `tbl_customer_order_idtbl_customer_order`) VALUES('-', '$updatedatetime', '$total', '$fullDiscount', '0', '$nettotal', '0', '1', '$updatedatetime', '$userID', '$areaId', '$customerId', '$locationId', '$poID')";
        $conn->query($insertInvoice);
        $invoiceId = $conn->insert_id;

        $dateformat = date('y/m/');
        $invoiceNo = 'IV/'. $dateformat . $invoiceId;

        $updateInvoiceNo="UPDATE `tbl_invoice` SET `invoiceno`='$invoiceNo' WHERE `idtbl_invoice` = '$invoiceId'";
        $conn->query($updateInvoiceNo);
    } 
}else if($acceptanceType == 2){
    $updatePoStatus="UPDATE  `tbl_customer_order` SET `dispatchissue`='1', `podiscount`='$podiscountAmount', `podiscountpercentage`='$podiscountPrecentage',  `discount`='$discount',`nettotal`='$nettotal', `total`='$total', `dispatchuser`='$userID' WHERE `idtbl_customer_order`='$poID'";

    $insertDispatch="INSERT INTO `tbl_cutomer_order_dispatch`(`dispatchdate`, `vehicleno`, `drivername`, `trackingno`, `trackingwebsite`, `currier`, `status`, `insertdatetime`, `tbl_user_idtbl_user`) VALUES('$updatedatetime', '-', '-', '-', '-', '-', '1', '$updatedatetime', '$userID')";
    $conn->query($insertDispatch);
    $dispatchId = $conn->insert_id;
            
    $insertDispatchInfo="INSERT INTO `tbl_cutomer_order_dispatch_has_tbl_customer_order`(`tbl_cutomer_order_dispatch_idtbl_cutomer_order_dispatch`, `tbl_customer_order_idtbl_customer_order`) VALUES('$dispatchId', '$poID')";
    $conn->query($insertDispatchInfo);
}else if($acceptanceType == 3){
    $updatePoStatus="UPDATE  `tbl_customer_order` SET `delivered`='1', `podiscount`='$podiscountAmount', `podiscountpercentage`='$podiscountPrecentage',  `ship`='1', `discount`='$discount',`nettotal`='$nettotal', `total`='$total', `delivereduser`='$userID', `shipuser`='$userID' WHERE `idtbl_customer_order`='$poID'";

    $getinvoicedata = "SELECT * FROM `tbl_invoice` WHERE `tbl_customer_order_idtbl_customer_order` = '$poID'";
    $resultinvoice = $conn->query($getinvoicedata);

    if ($resultinvoice->num_rows > 0) {
        $rowinvoice = $resultinvoice->fetch_assoc();
        $invoiceId = $rowinvoice['idtbl_invoice'];
        $invoiceNo = $rowinvoice['invoiceno'];
    }
}

if($conn->query($updatePoStatus)==true){

    foreach($tableData as $rowtabledata){
        $productID=$rowtabledata['col_3'];
        $podetailId=$rowtabledata['col_4'];
        $qty=$rowtabledata['col_5'];
        $linediscountprecentage=$rowtabledata['col_6'];
        $linediscountamount=$rowtabledata['col_7'];
        $status=$rowtabledata['col_11'];
        $fullTotal=$rowtabledata['col_12'];

        $netTotal = $fullTotal - $linediscountamount;

        if($acceptanceType == 1){
            $updatePoDetail="UPDATE  `tbl_customer_order_detail` SET `confirmqty`='$qty', `discountpresent`='$linediscountprecentage', `discount`='$linediscountamount', `total`='$netTotal', `status`='$status' WHERE `idtbl_customer_order_detail` = '$podetailId'";
            $conn->query($updatePoDetail);
            
            $updateHoldStock="UPDATE  `tbl_customer_order_hold_stock` SET `qty`='$qty', `status`='$status' WHERE `tbl_product_idtbl_product` = '$productID' AND `tbl_customer_order_idtbl_customer_order` = '$poID'";
        }else if($acceptanceType == 2){
            $updatePoDetail="UPDATE  `tbl_customer_order_detail` SET `dispatchqty`='$qty', `discountpresent`='$linediscountprecentage', `discount`='$linediscountamount', `total`='$netTotal', `status`='$status' WHERE `idtbl_customer_order_detail` = '$podetailId'";
            $conn->query($updatePoDetail);

            $updateHoldStock="UPDATE  `tbl_customer_order_hold_stock` SET `qty`='$qty', `status`='$status' WHERE `tbl_product_idtbl_product` = '$productID' AND `tbl_customer_order_idtbl_customer_order` = '$poID'";
        }else if($acceptanceType == 3){
            $updateinvoicehead="UPDATE `tbl_invoice` SET `total` = '$total', `discount` = '$fullDiscount', `nettotal` = '$nettotal', `updatedatetime` = '$updatedatetime'";
            $conn->query($updateinvoicehead);

            $updatePoDetail="UPDATE  `tbl_customer_order_detail` SET `qty`='$qty', `discountpresent`='$linediscountprecentage', `discount`='$linediscountamount', `total`='$netTotal', `status`='$status' WHERE `idtbl_customer_order_detail` = '$podetailId'";
            $conn->query($updatePoDetail);

            $updateHoldStock="UPDATE  `tbl_customer_order_hold_stock` SET `qty`='$qty', `status`='$status', `invoiceissue`='1' WHERE `tbl_product_idtbl_product` = '$productID' AND `tbl_customer_order_idtbl_customer_order` = '$poID'";

            $getporderdata = "SELECT * FROM `tbl_customer_order_detail` WHERE `idtbl_customer_order_detail` = '$podetailId' AND `status` = '1'";
            $result = $conn->query($getporderdata);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $unitprice = $row['unitprice'];
                $saleprice = $row['saleprice'];
                $total = $row['total'];
                $discount = $row['discount'];

                $insertInvoideDetail="INSERT INTO `tbl_invoice_detail`(`qty`, `unitprice`, `saleprice`, `discount`, `total`, `status`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_product_idtbl_product`, `tbl_invoice_idtbl_invoice`) VALUES('$qty', '$unitprice', '$saleprice', '$discount', '$total', '1', '$updatedatetime', '$userID', '$productID', '$invoiceId')";
                $conn->query($insertInvoideDetail);

                // Stock Update
                $productID = $row['tbl_product_idtbl_product'];
                $reducedqty = $qty;
                $freeproductid = 0;
                $freeqty = 0;

                $getstock = "SELECT * FROM `tbl_stock` WHERE `qty` > 0 AND `tbl_product_idtbl_product` = '$productID' ORDER BY SUBSTRING(batchno, 4) ASC LIMIT 1";
                $result = $conn->query($getstock);
                $stockdata = $result->fetch_assoc();

                $stockbatch = $stockdata['batchno'];
                $batchqty = $stockdata['qty'];

                while($batchqty < $reducedqty){
                    $updatestock="UPDATE `tbl_stock` SET `qty`=0 WHERE `tbl_product_idtbl_product`='$productID' AND `batchno` = '$stockbatch'";
                    $conn->query($updatestock);
        
                    $reducedqty = $reducedqty - $batchqty;
        
                    $regetstock = "SELECT * FROM `tbl_stock` WHERE `qty` > 0 AND `tbl_product_idtbl_product` = '$productID' ORDER BY SUBSTRING(batchno, 4) ASC LIMIT 1";
                    $reresult =$conn-> query($regetstock); 
                    $restockdata = $reresult-> fetch_assoc();
        
                    $stockbatch = $restockdata['batchno'];
                    $batchqty = $restockdata['qty'];
        
                    if($batchqty > $reducedqty){
                        break;
                    }
                }
                // echo $reducedqty;
        
                $updatestock="UPDATE `tbl_stock` SET `qty`=(`qty`-'$reducedqty') WHERE `tbl_product_idtbl_product`='$productID' AND `batchno` = '$stockbatch'";
                $conn->query($updatestock);
            
                $updatestockfree="UPDATE `tbl_stock` SET `qty`=(`qty`-'$freeqty') WHERE `tbl_product_idtbl_product`='$freeproductid'";
                $conn->query($updatestockfree);
            } 

            
        }
        
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
