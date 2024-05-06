<?php
require_once('../connection/db.php');

$customerId=$_POST['recordId'];

$sqlinfo="SELECT * FROM `tbl_customer` AS `c` JOIN `tbl_return` AS `r` ON (`r`.`tbl_customer_idtbl_customer` = `c`.`idtbl_customer`) WHERE `r`.`acceptance_status`=1 AND `r`.`status`=1 AND `c`.`idtbl_customer`='$customerId'";
$resultinfo=$conn->query($sqlinfo);
$detailarray=array();
while($rowinfo=$resultinfo->fetch_assoc()){
    $obj=new stdClass();
    $obj->returnid=$rowinfo['idtbl_return'];
    $obj->customerId=$rowinfo['idtbl_customer'];
    $obj->customerName=$rowinfo['name'];

    array_push($detailarray, $obj);
}

echo json_encode($detailarray);