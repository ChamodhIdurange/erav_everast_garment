<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location:index.php");
}
require_once('../connection/db.php'); //die('bc');
$userID = $_SESSION['userid'];
$returnid = $_POST['id'];
$balAmount = $_POST['balAmount'];
$payAmount = $_POST['payAmount'];
$returnamount = $_POST['returnamount'];
$tableData = $_POST['tblData'];
$updatedatetime = date('Y-m-d h:i:s');
$ctndate = date('Y-m-d');
$hideblnsamnt = $_POST['hideblnsamnt'];
$insertcreditenote = "INSERT INTO `tbl_creditenote`(`returnamount`, `payAmount`, `balAmount`, `baltotalamount`, `returnid`, `status`, `ctndate`, `updatedatetime`, `tbl_user_idtbl_user`) VALUES ('$returnamount','$payAmount','$balAmount', '$hideblnsamnt', '$returnid','1','$ctndate','$updatedatetime','$userID')";
if ($conn->query($insertcreditenote) == true) {
    $creditenoteID = $conn->insert_id;

    foreach ($tableData as $rowtabledata) {


        $type = $rowtabledata['col_8'];
        $invoice = substr($rowtabledata['col_3'], 0, 4);
        $rtntotal = $rowtabledata['col_6'];
        $invtotal = $rowtabledata['col_7'];
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $insertcreditenotedetail = "INSERT INTO `tbl_creditenote_detail`(`type`, `cash`, `invtotal`, `invoice`, `status`, `updatedatetime`, `tbl_creditenote_idtbl_creditenote`) VALUES ('$type','$rtntotal','$invtotal','$invoice','1','$updatedatetime','$creditenoteID')";
        $conn->query($insertcreditenotedetail);
    }
    $sqlupdate = "UPDATE `tbl_return` SET `credit_note_issue`='1' WHERE `idtbl_return`='$returnid'";
    if ($conn->query($sqlupdate) == true) {
        $actionObj = new stdClass();
        $actionObj->icon = 'fas fa-check-circle';
        $actionObj->title = '';
        $actionObj->message = 'Add Successfully';
        $actionObj->url = '';
        $actionObj->target = '_blank';
        $actionObj->type = 'success';

        $obj = new stdClass();
        $obj->action = json_encode($actionObj);

        echo json_encode($obj);
    } else {

        $actionObj = new stdClass();
        $actionObj->icon = 'fas fa-exclamation-triangle';
        $actionObj->title = '';
        $actionObj->message = 'Record Error';
        $actionObj->url = '';
        $actionObj->target = '_blank';
        $actionObj->type = 'danger';

        $obj = new stdClass();
        $obj->action = json_encode($actionObj);


        echo json_encode($obj);
    }
}
