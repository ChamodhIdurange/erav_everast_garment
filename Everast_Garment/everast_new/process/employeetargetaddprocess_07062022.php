<?php 
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('../connection/db.php');
$userID=$_SESSION['userid'];


$tableData=$_POST['tableData'];
$targetmonth=$_POST['targetmonth'];
$employee=$_POST['employee'];
$updatedatetime=date('Y-m-d h:i:s');

$targetmonth = $targetmonth. '-1';
$insert="INSERT INTO `tbl_employee_target`(`month`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_employee_idtbl_employee`) VALUES ('$targetmonth','$updatedatetime','$userID','$employee')";
if($conn->query($insert)==true){        
    $last_id = mysqli_insert_id($conn); 

        foreach($tableData as $rowtabledata){
            $productID=$rowtabledata['col_1'];
            $qty=$rowtabledata['col_3'];
            $insertemptargetdetails="INSERT INTO `tbl_employee_target_details`(`tbl_product_idtbl_product`, `target`, `current_value`, `target_status`, `tbl_employee_target_idtbl_employee_target`, `updatedatetime`) VALUES ('$productID','$qty','0','0','$last_id','$updatedatetime')";
            $conn->query($insertemptargetdetails);
        }


        $actionObj=new stdClass();
        $actionObj->icon='fas fa-check-circle';
        $actionObj->title='';
        $actionObj->message='Record added Successfully';
        $actionObj->url='';
        $actionObj->target='_blank';
        $actionObj->type='success';
    
        echo $actionJSON=json_encode($actionObj);
        
}
else{
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