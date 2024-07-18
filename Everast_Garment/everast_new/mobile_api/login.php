<?php

require_once('dbConnect.php');
$username = $_POST["username"];
$password1 = $_POST["password"];

$md5password = md5($password1);
$id = "";
$type = "";
$refName = "";
$phone = "";
$address = "";
$code = "500";
$emp_id = "";
$LastMobileInnoNo = "";

$sql = "SELECT * FROM `tbl_user` WHERE `status`='1' AND  `username`='$username' AND `password`='$md5password'";
$result = mysqli_query($con, $sql);
// $response = array();
if (mysqli_num_rows($result) > 0) {

    $row = mysqli_fetch_row($result);
    $id = $row[0];
    $sqlRefData = "SELECT `idtbl_employee`, `name`, `epfno`, `nic`, `phone`, `address`, `status`, `updatedatetime`,`tbl_user_type_idtbl_user_type` FROM `tbl_employee` WHERE `tbl_user_idtbl_user`='$id'";
    $resultRefData = mysqli_query($con, $sqlRefData);

    $rowRefDta = mysqli_fetch_array($resultRefData);
    $refName = "";
    $phone = "";
    $emp_id = "";
    $userType = "";
    if ($rowRefDta) {
        $refName = $rowRefDta['name'];
        $phone = $rowRefDta['phone'];
        $emp_id = $rowRefDta['idtbl_employee'];
        $userType = $rowRefDta['tbl_user_type_idtbl_user_type'];
    }
    $sqlMoInno = "SELECT `mobileid` FROM `tbl_porder_otherinfo` WHERE `repid`='$id' ORDER BY `tbl_porder_otherinfo`.`updatedatetime` DESC LIMIT 1";
    $resultMoInno = mysqli_query($con, $sqlMoInno);

    if (mysqli_num_rows($resultMoInno) > 0) {

        $rowRefDtamobile = mysqli_fetch_array($resultMoInno);
        $LastMobileInnoNo = $rowRefDtamobile['mobileid'];
    }
    $code = "200";

    $response = array("code" => $code, "refid" => $id, "empid" => $emp_id, "name" => $refName, "mobile" =>  $phone, "lastInnoNo" => $LastMobileInnoNo, "userType" => $userType);
    print_r(json_encode($response));
} else {

    $code = "500";
    $response = array("code" => $code, "refid" => $id, "empid" => $emp_id, "name" => $refName, "mobile" => $phone, "lastInnoNo" => $LastMobileInnoNo, "userType" => $userType);
    print_r(json_encode($response));
}
mysqli_close($con);
