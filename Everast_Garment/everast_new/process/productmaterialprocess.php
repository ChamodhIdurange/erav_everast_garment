<?php 

// NOT IN USE

session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('../connection/db.php');//die('bc');
$userID=$_SESSION['userid'];

$productID=$_POST['productID'];
$tableData=$_POST['tableData'];

$updatedatetime=date('Y-m-d h:i:s');

foreach($tableData as $rowtabledata){
    $materialid=$rowtabledata['col_2'];
    $requiredqty=$rowtabledata['col_4'];

    $check = "SELECT `idtbl_product_materials` from `tbl_product_materials` WHERE `tbl_product_idtbl_product` = '$productID' AND `tbl_material_idtbl_material` = '$materialid'";
    $resultcheck =$conn-> query($check);

    if($resultcheck->num_rows > 0) {while ($row = $resultcheck-> fetch_assoc()) {
        $id = $row['idtbl_product_materials'];
        $updatesql ="UPDATE `tbl_product_materials` SET `qty` = '$requiredqty' WHERE `idtbl_product_materials` = '$id'";
        if($conn->query($updatesql)==false){
            $actionObj=new stdClass();
            $actionObj->icon='fas fa-exclamation-triangle';
            $actionObj->title='';
            $actionObj->message='Record Error';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='danger';
        
            echo $actionJSON=json_encode($actionObj);
            break;
        }
    }}else{
        $insert="INSERT INTO `tbl_product_materials`(`tbl_product_idtbl_product`, `tbl_material_idtbl_material`, `qty`, `status`, `tbl_user_idtbl_user`, `insertdatetime`) VALUES ('$productID','$materialid','$requiredqty','1','$userID','$updatedatetime')";
        if($conn->query($insert)==false){
            $actionObj=new stdClass();
            $actionObj->icon='fas fa-exclamation-triangle';
            $actionObj->title='';
            $actionObj->message='Record Error';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='danger';
        
            echo $actionJSON=json_encode($actionObj);
            break;
        }
    }

    
}

$actionObj=new stdClass();
$actionObj->icon='fas fa-check-circle';
$actionObj->title='';
$actionObj->message='Record added Successfully';
$actionObj->url='';
$actionObj->target='_blank';
$actionObj->type='success';
    
echo $actionJSON=json_encode($actionObj);
        