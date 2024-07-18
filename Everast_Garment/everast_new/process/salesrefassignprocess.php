<?php 
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('../connection/db.php');//die('bc');
$userID=$_SESSION['userid'];

$salesref=$_POST['salesref'];
$tableData=$_POST['tableData'];

$updatedatetime=date('Y-m-d h:i:s');



foreach($tableData as $rowtabledata){
    $customerid=$rowtabledata['col_1'];
    $refid=$rowtabledata['col_4'];

    $sql="UPDATE `tbl_customer` SET `ref` = '$refid', `updatedatetime` = '$updatedatetime' WHERE `idtbl_customer` = '$customerid' ";
    $conn->query($sql);
}

$actionObj=new stdClass();
$actionObj->icon='fas fa-check-circle';
$actionObj->title='';
$actionObj->message='Updated Successfully';
$actionObj->url='';
$actionObj->target='_blank';
$actionObj->type='primary';

echo $actionJSON=json_encode($actionObj);

