<?php 
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('../connection/db.php');
$userID=$_SESSION['userid'];


$updatedatetime=date('Y-m-d h:i:s');


$remarks=$_POST['remarks'];
$typeID=$_POST['typeID'];
$customerId=$_POST['customerId'];
$returninvoice=$_POST['returninvoice'];
// $total=$_POST['total'];
$tableData=$_POST['tableData'];


$insertorder = "INSERT INTO `tbl_free_issue`(`tbl_freeissue_type_idtbl_freeissue_type`, `reason`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_customer_idtbl_customer`, `tbl_invoice_idtbl_invoice`, `status`) VALUES ('$typeID', '$remarks','$updatedatetime','$userID', '$customerId', '$returninvoice', '1')";
if($conn->query($insertorder)==true){
    $last_id = mysqli_insert_id($conn); 
    
    foreach($tableData as $rowtabledata){
        $productID=$rowtabledata['col_1'];
        $qty=$rowtabledata['col_3'];
        $reducedqty = $qty;

        $getstock = "SELECT * FROM `tbl_stock` WHERE `qty` > 0 AND `tbl_product_idtbl_product` = '$productID' ORDER BY SUBSTRING(batchno, 4) ASC LIMIT 1";
        $result =$conn-> query($getstock); 
        $stockdata = $result-> fetch_assoc();

        $stockbatch = $stockdata['batchno'];
        $batchqty = $stockdata['qty'];

        $query = "INSERT INTO `tbl_free_issue_details`(`tbl_free_issue_idtbl_free_issue`, `tbl_product_idtbl_product`, `qty`) VALUES ('$last_id','$productID','$qty')";
        $conn->query($query);

        while($batchqty < $reducedqty){
            $updatestock="UPDATE `tbl_stock` SET `qty`=0 WHERE `tbl_product_idtbl_product`='$productID' AND `batchno` = '$stockbatch'";
            $conn->query($updatestock);

            $regetstock = "SELECT * FROM `tbl_stock` WHERE `qty` > 0 AND `tbl_product_idtbl_product` = '$productID' ORDER BY SUBSTRING(batchno, 4) ASC LIMIT 1";
            $reresult =$conn-> query($regetstock); 
            $restockdata = $reresult-> fetch_assoc();

            $reducedqty = $reducedqty - $batchqty;

            $stockbatch = $restockdata['batchno'];
            $batchqty = $restockdata['qty'];

            if($batchqty > $reducedqty){
                break;
            }
        }

        $updatestock="UPDATE `tbl_stock` SET `qty`=(`qty`-'$reducedqty') WHERE `tbl_product_idtbl_product`='$productID' AND `batchno` = '$stockbatch'";
        $conn->query($updatestock);
    }

    $actionObj=new stdClass();
    $actionObj->icon='fas fa-check-circle';
    $actionObj->title='';
    $actionObj->message='Add Successfully';
    $actionObj->url='';
    $actionObj->target='_blank';
    $actionObj->type='success';

    $obj=new stdClass();
    $obj->action=json_encode($actionObj);

    echo json_encode($obj);
}else{
    $actionObj=new stdClass();
    $actionObj->icon='fas fa-exclamation-triangle';
    $actionObj->title='';
    $actionObj->message='Record Error';
    $actionObj->url='';
    $actionObj->target='_blank';
    $actionObj->type='danger';

    $obj=new stdClass();
    $obj->action=json_encode($actionObj);
    echo json_encode($obj);
}
