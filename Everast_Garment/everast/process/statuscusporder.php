<?php 
session_start();
if(!isset($_SESSION['userid'])){header ("Location:../index.php");}
require_once('../connection/db.php');

$userID=$_SESSION['userid'];
if(!empty($_POST['recordreturnID'])){
    $record=$_POST['recordreturnID'];
    $returnprice=$_POST['returnprice'];
    $returnreason=$_POST['returnreason'];
}
else{
    $record=$_POST['recordID'];
}
$type=$_POST['type'];
$cancelreason=$_POST['cancelreason'];
$updatedatetime=date('Y-m-d h:i:s');

if($type==1){
    $sql="UPDATE `tbl_porder` SET `paystatus`='1',`updatedatetime`='$updatedatetime',`tbl_user_idtbl_user`='$userID' WHERE `idtbl_porder`='$record'";
    if($conn->query($sql)==true){        
        $actionObj=new stdClass();
        $actionObj->icon='fas fa-check-circle';
        $actionObj->title='';
        $actionObj->message='Payment Successfully';
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
}
else if($type==2){
    $sql="UPDATE `tbl_porder` SET `shipstatus`='1',`updatedatetime`='$updatedatetime',`tbl_user_idtbl_user`='$userID' WHERE `idtbl_porder`='$record'";
    if($conn->query($sql)==true){
        $actionObj=new stdClass();
        $actionObj->icon='fas fa-check-circle';
        $actionObj->title='';
        $actionObj->message='Shiped Successfully';
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
}
else if($type==3){
    $sql="UPDATE `tbl_porder` SET `deliverystatus`='1',`updatedatetime`='$updatedatetime',`tbl_user_idtbl_user`='$userID' WHERE `idtbl_porder`='$record'";
    if($conn->query($sql)==true){
        $actionObj=new stdClass();
        $actionObj->icon='fas fa-check-circle';
        $actionObj->title='';
        $actionObj->message='Delivery Successfully';
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
}
else if($type==4){
    $sql="UPDATE `tbl_porder` SET `status`='2',`cancelreason`='$cancelreason',`updatedatetime`='$updatedatetime',`tbl_user_idtbl_user`='$userID' WHERE `idtbl_porder`='$record'";
    if($conn->query($sql)==true){
        header("Location:../orderlist.php?action=7");
    }
    else{header("Location:../orderlist.php?action=5");}
}
else if($type==5){

    $sql="UPDATE `tbl_porder` SET `confirmstatus`='1',`updatedatetime`='$updatedatetime',`tbl_user_idtbl_user`='$userID' WHERE `idtbl_porder`='$record'";
    if($conn->query($sql)==true){

        $sqlpOrderDetails = "SELECT `p`.`orderdate`,`d`.`tbl_product_idtbl_product`,`d`.`qty`,`o`.`repid` FROM `tbl_porder` AS `p` JOIN `tbl_porder_detail` AS `d` ON (`p`.`idtbl_porder` = `d`.`tbl_porder_idtbl_porder`) JOIN `tbl_porder_otherinfo` AS `o` ON (`o`.`porderid` = `p`.`idtbl_porder`) WHERE `d`.`tbl_porder_idtbl_porder` = '$record'";
        $resultDetails =$conn-> query($sqlpOrderDetails);
        
        // Uncomment this only if you want to make target after  confirmation of porder
        // if($resultDetails->num_rows > 0) {while ($row = $resultDetails-> fetch_assoc()) {
        //     $date = $row['orderdate'];
        //     $date = substr($date, 0, 7);
        //     $date = $date.'-01';
        //     $productID = $row['tbl_product_idtbl_product'];
        //     $qty = $row['qty'];
        //     $repID = $row['repid'];
          
    
        //     $c = 1;
    
    
        //     if($c = 1){
        //         $sqlTarget = "SELECT `idtbl_employee_target` FROM `tbl_employee_target` WHERE `month` = '$date' AND `tbl_employee_idtbl_employee` = '$repID'";
        //         $resultTarget =$conn-> query($sqlTarget);
        //         if($resultTarget->num_rows > 0) {while ($result2 = $resultTarget-> fetch_assoc()) {
        //             $targetID = $result2['idtbl_employee_target'];
        //             echo "<script>console.log('" . $date . "' );</script>";
    
        //             $sqlUpdate="UPDATE `tbl_employee_target_details` SET `current_value`=(`current_value`+'$qty') ,`updatedatetime`='$date' WHERE `tbl_employee_target_idtbl_employee_target`='$targetID' AND `tbl_product_idtbl_product` = '$productID'";
        //             $resultUpdate =$conn-> query($sqlUpdate);
        //             $c = 2;
    
                  
        //         }}
        //     }else{
        //         $sqlUpdate="UPDATE `tbl_employee_target_details` SET `current_value`=(`current_value`+'$qty'),`updatedatetime`='$updatedatetime' WHERE `tbl_employee_target_idtbl_employee_target`='$targetID' AND `tbl_product_idtbl_product` = '$productID'";
        //         $resultUpdate =$conn-> query($sqlUpdate);
        //     }
        // }}
        
      
        
        $actionObj=new stdClass();
        $actionObj->icon='fas fa-check';
        $actionObj->title='';
        $actionObj->message='Order Accept Successfully';
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
}
else if($type==6){
    $sql="UPDATE `tbl_porder` SET `callstatus`='1',`updatedatetime`='$updatedatetime',`tbl_user_idtbl_user`='$userID' WHERE `idtbl_porder`='$record'";
    if($conn->query($sql)==true){
        $actionObj=new stdClass();
        $actionObj->icon='fas fa-check-circle';
        $actionObj->title='';
        $actionObj->message='Delivery Successfully';
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
}
else if($type==7){
    $sql="UPDATE `tbl_porder` SET `status`='1',`updatedatetime`='$updatedatetime',`tbl_user_idtbl_user`='$userID' WHERE `idtbl_porder`='$record'";
    if($conn->query($sql)==true){
        $actionObj=new stdClass();
        $actionObj->icon='fas fa-check-circle';
        $actionObj->title='';
        $actionObj->message='Reactive Successfully';
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
}
else if($type==8){
    $sql="UPDATE `tbl_porder` SET `returnstatus`='1',`status`='2',`updatedatetime`='$updatedatetime',`tbl_user_idtbl_user`='$userID' WHERE `idtbl_porder`='$record'";
    if($conn->query($sql)==true){        
        header("Location:../orderlist.php?action=8");
    }
    else{header("Location:../orderlist.php?action=5");}
}

?>