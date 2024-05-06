<?php
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('../connection/db.php');//die('bc');
$userID=$_SESSION['userid'];

$elecid = $_POST['elecid'];
$offerid = $_POST['offerid'];
$points = $_POST['points'];


$updatedatetime=date('Y-m-d h:i:s');


        foreach($elecid as $elec){ 
            $sql3="SELECT `star_points` FROM `tbl_electrician` WHERE `idtbl_electrician` = '$elec'";
            $result3=$conn->query($sql3);
            
            
            while ($row = $result3-> fetch_assoc()) {
                $elecstarpoints=  $row['star_points'];
            }
   
            $elecstarpoints = $elecstarpoints - $points;
            $insert="INSERT INTO `tbl_elec_offer`(`tbl_offer_idtbl_offer`, `tbl_electrician_idtbl_electrician`) VALUES ('$offerid','$elec')";
            if($conn->query($insert)==true){ 
  
                $updateelec="UPDATE `tbl_electrician` SET `star_points`='$elecstarpoints' WHERE `idtbl_electrician`='$elec'";
                if($conn->query($updateelec)==true){

                }
            }
        }

        header("Location:../offer.php?action=4");

?>