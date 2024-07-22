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


// $updatePo="UPDATE  `tbl_porder` SET `discount`='$discount',`nettotal`='$nettotal', `subtotal`='$total'  WHERE `idtbl_porder`='$poID'";
if($acceptanceType == 1){
    $updatePo="UPDATE  `tbl_customer_order` SET `confirm`='1' WHERE `idtbl_customer_order`='$poID'";
}else if($acceptanceType == 2){
    $updatePo="UPDATE  `tbl_customer_order` SET `dispatchissue`='1' WHERE `idtbl_customer_order`='$poID'";
}else if($acceptanceType == 3){
    $updatePo="UPDATE  `tbl_customer_order` SET `delivered`='1' WHERE `idtbl_customer_order`='$poID'";
}

if($conn->query($updatePo)==true){

    // foreach($tableData as $rowtabledata){
    //     $productID=$rowtabledata['col_2'];
    //     $qty=$rowtabledata['col_3'];


    //     $updatePoDetail="UPDATE  `tbl_porder_detail` SET `qty`='$qty' WHERE `tbl_product_idtbl_product`='$productID' AND `tbl_porder_idtbl_porder` = '$poID'";
    //     $conn->query($updatePoDetail);

    // }
        
    $actionObj=new stdClass();
    $actionObj->icon='fas fa-check-circle';
    $actionObj->title='';
    $actionObj->message='Add Successfully';
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