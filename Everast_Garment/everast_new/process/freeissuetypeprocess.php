<?php 
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('../connection/db.php');
$userID=$_SESSION['userid'];

$recordOption=$_POST['recordOption'];
if(!empty($_POST['recordID'])){$recordID=$_POST['recordID'];}
$category=$_POST['category'];
$updatedatetime=date('Y-m-d h:i:s');
$status = 1;
// print_r($recordOption)
if($recordOption==1){
    $insert="INSERT INTO `tbl_freeissue_type`(`type`, `status`, `updatedatetime`, `tbl_user_idtbl_user`) VALUES ('$category','$status','$updatedatetime','$userID')";
    if($conn->query($insert)==true){        
        header("Location:../freeissuetype.php?action=4");
    }
    else{header("Location:../freeissuetype.php?action=5");}
}
else{
    $update="UPDATE `tbl_freeissue_type` SET `type`='$category',`updatedatetime`='$updatedatetime',`tbl_user_idtbl_user`='$userID' WHERE `idtbl_freeissue_type`='$recordID'";
    if($conn->query($update)==true){     
        header("Location:../freeissuetype.php?action=6");
    }
    else{header("Location:../freeissuetype.php?action=5");}
}
?>