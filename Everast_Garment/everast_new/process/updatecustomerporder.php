<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("");
}
require_once('../connection/db.php');

$userID = $_SESSION['userid'];
$updatedatetime = date('Y-m-d h:i:s');

$customerid = $_POST['customerid'];
$orderdate = $_POST['orderdate'];
$porderId = $_POST['porderId'];


$sql = "UPDATE `tbl_customer_order` SET `tbl_customer_idtbl_customer`='$customerid', `date`='$orderdate' WHERE `idtbl_customer_order`='$porderId'";

if ($conn->query($sql) == true) {
    $actionObj = new stdClass();
    $actionObj->icon = 'fas fa-check-circle';
    $actionObj->title = '';
    $actionObj->message = 'Record Updated Successfully';
    $actionObj->url = '';
    $actionObj->target = '_blank';
    $actionObj->type = 'success';
    echo $actionJSON=json_encode($actionObj);
} else {
    $actionObj=new stdClass();
    $actionObj->icon='fas fa-exclamation-triangle';
    $actionObj->title='';
    $actionObj->message='Record Error';
    $actionObj->url='';
    $actionObj->target='_blank';
    $actionObj->type='danger';

    echo $actionJSON=json_encode($actionObj);
}
