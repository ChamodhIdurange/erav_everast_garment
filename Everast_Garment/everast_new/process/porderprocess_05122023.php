<?php 
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
if(!isset($_POST['assembledpo'])){
    $assempledpo=0;
}else{
    $assempledpo=1;
}
require_once('../connection/db.php');//die('bc');
$userID=$_SESSION['userid'];

$orderdate=$_POST['orderdate'];
$ismaterialpo=$_POST['ordertype'];
$remark=$_POST['remark'];
$total=$_POST['total'];
$tableData=$_POST['tableData'];

$updatedatetime=date('Y-m-d h:i:s');

if($assempledpo == 0){
    $insretorder="INSERT INTO `tbl_porder`(`potype`, `ismaterialpo`, `orderdate`, `subtotal`, `disamount`, `discount`, `nettotal`, `payfullhalf`, `remark`, `confirmstatus`, `dispatchissue`, `grnissuestatus`, `paystatus`, `shipstatus`, `deliverystatus`, `trackingno`, `trackingwebsite`, `callstatus`, `narration`, `cancelreason`, `returnstatus`, `status`, `updatedatetime`, `tbl_user_idtbl_user`) VALUES ('0', '$ismaterialpo', '$orderdate','$total','0','0','$total','0','$remark','0','0','0','0','0','0','','-','0','-','-','0','1','$updatedatetime','$userID')";
}else{
    $insretorder="INSERT INTO `tbl_porder`(`potype`, `ismaterialpo`, `isassemblepo`, `orderdate`, `subtotal`, `disamount`, `discount`, `nettotal`, `payfullhalf`, `remark`, `confirmstatus`, `dispatchissue`, `grnissuestatus`, `paystatus`, `shipstatus`, `deliverystatus`, `trackingno`, `trackingwebsite`, `callstatus`, `narration`, `cancelreason`, `returnstatus`, `status`, `updatedatetime`, `tbl_user_idtbl_user`) VALUES ('0', '$ismaterialpo', '$assempledpo', '$orderdate','$total','0','0','$total','0','$remark','0','1','0','1','1','1','','-','0','-','-','0','1','$updatedatetime','$userID')";
}
if($conn->query($insretorder)==true){
    $orderID=$conn->insert_id;
    foreach($tableData as $rowtabledata){
        $product=$rowtabledata['col_2'];
        $unitprice=$rowtabledata['col_3'];
        $saleprice=$rowtabledata['col_4'];
        $newqty=$rowtabledata['col_5'];
        $total=$rowtabledata['col_6'];

        if($ismaterialpo == 0){
            $insertorderdetail="INSERT INTO `tbl_porder_detail`(`type`, `qty`, `freeqty`, `unitprice`, `saleprice`, `status`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_porder_idtbl_porder`, `tbl_product_idtbl_product`) VALUES ('0','$newqty','0','$unitprice','$saleprice','1','$updatedatetime','$userID','$orderID','$product')";
        }else{
            $insertorderdetail="INSERT INTO `tbl_porder_detail`(`type`, `qty`, `freeqty`, `unitprice`, `saleprice`, `status`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_porder_idtbl_porder`, `tbl_material_idtbl_material`) VALUES ('0','$newqty','0','$unitprice','$saleprice','1','$updatedatetime','$userID','$orderID','$product')";
        }
        $conn->query($insertorderdetail);
    }

    $insertpayment = "INSERT INTO `tbl_porder_payment`(`date`, `ordertotal`, `previousbill`, `balancetotal`, `accountstatus`, `status`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_porder_idtbl_porder`) VALUES ('$orderdate','$total','0','0','0','1','$updatedatetime','$userID','$orderID')";
    $conn->query($insertpayment);

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