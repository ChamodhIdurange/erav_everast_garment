<?php
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('../connection/db.php');//die('bc');
$userID=$_SESSION['userid'];

$name = $_POST['name'];
$arangeddate=$_POST['arangeddate'];
$location=$_POST['location'];
$points=$_POST['points'];
$remarks=$_POST['remarks'];

$updatedatetime=date('Y-m-d h:i:s');

    $query = "INSERT INTO `tbl_offer` (`name`, `arranged_date`, `location`, `required_points`, `remarks`, `tbl_user_idtbl_user`,`status`) Values ('$name','$arangeddate','$location','$points','$remarks','$userID','1')";
    if($conn->query($query)==true){
        $last_id = mysqli_insert_id($conn); 
        header("Location:../offer.php?action=4");
    }else{
        header("Location:../offer.php?action=5");
    }

?>
<!-- 
// foreach($electrician as $elec){ 
        //     $sql3="SELECT `star_points` FROM `tbl_electrician` WHERE `idtbl_electrician` = '$elec'";
        //     $result3=$conn->query($sql3);
            
            
        //     while ($row = $result3-> fetch_assoc()) {
        //         $elecstarpoints=  $row['star_points'];
        //     }
   
        //     $elecstarpoints = $elecstarpoints - $points;
        //     $insert="INSERT INTO `tbl_elec_offer`(`tbl_offer_idtbl_offer`, `tbl_electrician_idtbl_electrician`) VALUES ('$last_id','$elec')";
        //     if($conn->query($insert)==true){ 
  
        //         $updateelec="UPDATE `tbl_electrician` SET `star_points`='$elecstarpoints' WHERE `idtbl_electrician`='$elec'";
        //         if($conn->query($updateelec)==true){

        //         }
        //     }
        // } -->