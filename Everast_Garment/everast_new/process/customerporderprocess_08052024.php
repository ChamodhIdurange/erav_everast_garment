<?php 
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('../connection/db.php');//die('bc');
$userID=$_SESSION['userid'];

$orderdate=$_POST['orderdate'];
$remark=$_POST['remark'];
$discountpresentage=$_POST['discountpresentage'];
$total=$_POST['total'];
$discount=$_POST['discount'];
$nettotal=$_POST['nettotal'];
$repname=$_POST['repname'];
$area=$_POST['area'];
$customer=$_POST['customer'];
$paymentoption=$_POST['paymentoption'];
$tableData=$_POST['tableData'];
$tableData = json_decode($tableData);

$updatedatetime=date('Y-m-d h:i:s');

if($_POST['directcustomer'] != ''){
    $directcustomer =  $_POST['directcustomer'];
    $customercontact =  $_POST['customercontact'];
    $customeraddress =  $_POST['customeraddress'];
 
    $insertcustomer = "INSERT INTO `tbl_customer`(`type`, `name`, `nic`, `phone`, `email`, `address`, `vat_num`, `s_vat`, `numofvisitdays`, `creditlimit`, `credittype`, `creditperiod`, `emergencydate`, `status`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_area_idtbl_area`) VALUES ('1', '$directcustomer', '', '$customercontact', '', '$customeraddress', '', '', 0, 0, 0, 0,'','1','$updatedatetime', '$userID', '1')";
    $conn->query($insertcustomer);
 
    $customer = $conn->insert_id;
 }

$month=date('n');


$insretorder="INSERT INTO `tbl_porder`(`potype`, `orderdate`, `subtotal`, `disamount`, `discount`, `nettotal`, `payfullhalf`, `remark`, `confirmstatus`, `dispatchissue`, `grnissuestatus`, `paystatus`, `shipstatus`, `deliverystatus`, `trackingno`, `trackingwebsite`, `callstatus`, `narration`, `cancelreason`, `returnstatus`, `status`, `updatedatetime`, `tbl_user_idtbl_user`) VALUES ('1','$orderdate','$total','$discount','$discountpresentage','$nettotal','$paymentoption','$remark','0','0','0','0','0','0','','-','0','-','-','0','1','$updatedatetime','$userID')";
if($conn->query($insretorder)==true){
    $orderID=$conn->insert_id;

    $insertporderother="INSERT INTO `tbl_porder_otherinfo`(`porderid`, `mobileid`, `areaid`, `customerid`, `repid`, `status`, `updatedatetime`) VALUES ('$orderID','0','$area','$customer','$repname','1','$updatedatetime')";
    $conn->query($insertporderother);

    foreach($tableData as $rowtabledata){
        $productID=$rowtabledata->col_1;
        $product=$rowtabledata->col_3;
        $unitprice=$rowtabledata->col_4;
        $saleprice=$rowtabledata->col_5;
        $newqty=$rowtabledata->col_6;
        $freeprodcutid=$rowtabledata->col_8;
        $freeqty=$rowtabledata->col_9;
        $totqty=$rowtabledata->col_10;
        $total=$rowtabledata->col_12;

        $insertorderdetail="INSERT INTO `tbl_porder_detail`(`type`, `qty`, `freeqty`, `freeproductid`, `unitprice`, `saleprice`, `status`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_porder_idtbl_porder`, `tbl_product_idtbl_product`) VALUES ('0','$newqty','$freeqty','$product','$unitprice','$saleprice','1','$updatedatetime','$userID','$orderID','$product')";
        $conn->query($insertorderdetail);

        $updatereptarget="UPDATE `tbl_employee_target` SET `targetqtycomplete`=(`targetqtycomplete`+'$newqty') WHERE MONTH(`month`)='$month' AND `status`=1 AND `tbl_employee_idtbl_employee`='$repname' AND `tbl_product_idtbl_product`='$product'";
        $conn->query($updatereptarget);

        $updatereptargetfree="UPDATE `tbl_employee_target` SET `targetqtycomplete`=(`targetqtycomplete`+'$freeqty') WHERE MONTH(`month`)='$month' AND `status`=1 AND `tbl_employee_idtbl_employee`='$repname' AND `tbl_product_idtbl_product`='$product'";
        $conn->query($updatereptargetfree);
    }

    $actionObj=new stdClass();
    $actionObj->icon='fas fa-check-circle';
    $actionObj->title='';
    $actionObj->message='Add Successfully';
    $actionObj->url='';
    $actionObj->target='_blank';
    $actionObj->type='success';

    echo $actionJSON=json_encode($actionObj);
}
else{
    $actionObj=new stdClass();
    $actionObj->icon='fas fa-exclamation-triangle';
    $actionObj->title='';
    $actionObj->message='Record Error';
    $actionObj->url='';
    $actionObj->target='_blank';
    $actionObj->type='danger';

    echo $actionJSON=json_encode($actionObj);
}




