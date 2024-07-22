<?php
require_once('../connection/db.php');

$productmaterialid = $_POST['recordID'];

// NOT IN USE

$sql = "DELETE FROM `tbl_product_materials` WHERE `idtbl_product_materials` = '$productmaterialid'";
if($conn->query($sql)==false){
    $actionObj=new stdClass();
    $actionObj->icon='fas fa-check-circle';
    $actionObj->title='';
    $actionObj->message='Record added Successfully';
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
?>
