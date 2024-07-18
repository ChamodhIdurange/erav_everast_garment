<?php 
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('../connection/db.php');//die('bc');
$userID=$_SESSION['userid'];

$orderdate=$_POST['orderdate'];
$remark=$_POST['remark'];
$productid=$_POST['productid'];
$qty=$_POST['qty'];
$updatedatetime=date('Y-m-d h:i:s');

$tableData=$_POST['tableData'];

$checkqty = "SELECT `qty` FROM `tbl_assembled_stock` WHERE `tbl_product_idtbl_product` = '$productid'";
$checkresult = $conn->query($checkqty);


$insertgrn="INSERT INTO `tbl_assembled_products`(`date`, `remarks`, `qty`, `updatedatetime`, `status`, `tbl_product_idtbl_product`, `tbl_user_idtbl_user`) VALUES ('$orderdate','$remark','$qty','$updatedatetime','1','$productid','$userID')";
if($conn->query($insertgrn)==true){

    if($checkresult->num_rows > 0){
        $updateassembledstock = "UPDATE `tbl_assembled_stock` SET `qty`=(`qty`+'$qty') WHERE `tbl_product_idtbl_product`='$productid'";
        $conn->query($updateassembledstock);
    }else{
        $insertstock="INSERT INTO `tbl_assembled_stock`(`qty`, `tbl_product_idtbl_product`, `updatedatetime`, `status`) VALUES ('$qty','$productid','$updatedatetime','1')";
        $conn->query($insertstock);
    }

    foreach($tableData as $rowtabledata){
        $materialid=$rowtabledata['col_1'];
        $qty=$rowtabledata['col_3'];
        $reducedqty=$qty;

        $getstock = "SELECT * FROM `tbl_material_stock` WHERE `qty` > 0 AND `tbl_material_idtbl_material` = '$materialid' ORDER BY SUBSTRING(batchno, 4) ASC LIMIT 1";
        $result =$conn-> query($getstock); 
        $stockdata = $result-> fetch_assoc();

        $stockbatch = $stockdata['batchno'];
        $batchqty = $stockdata['qty'];

        while($batchqty < $reducedqty){
            $updatestock="UPDATE `tbl_material_stock` SET `qty`=0 WHERE `tbl_material_idtbl_material`='$materialid' AND `batchno` = '$stockbatch'";
            $conn->query($updatestock);

            $reducedqty = $reducedqty - $batchqty;

            $regetstock = "SELECT * FROM `tbl_material_stock` WHERE `qty` > 0 AND `tbl_material_idtbl_material` = '$materialid' ORDER BY SUBSTRING(batchno, 4) ASC LIMIT 1";
            $reresult =$conn-> query($regetstock); 
            $restockdata = $reresult-> fetch_assoc();

            $stockbatch = $restockdata['batchno'];
            $batchqty = $restockdata['qty'];

            if($batchqty > $reducedqty){
                break;
            }
        }
        $updatestock="UPDATE `tbl_material_stock` SET `qty`=(`qty`-'$reducedqty') WHERE `tbl_material_idtbl_material`='$materialid' AND `batchno` = '$stockbatch'";
        $conn->query($updatestock);
    }
}

$actionObj=new stdClass();
$actionObj->icon='fas fa-check-circle';
$actionObj->title='';
$actionObj->message='Add Successfully';
$actionObj->url='';
$actionObj->target='_blank';
$actionObj->type='success';

echo $actionJSON=json_encode($actionObj);
