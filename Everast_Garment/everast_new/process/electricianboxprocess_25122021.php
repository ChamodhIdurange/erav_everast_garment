<?php
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('../connection/db.php');//die('bc');
$userID=$_SESSION['userid'];

$recordOption=$_POST['recordOption'];

$addeddate=$_POST['addeddate'];

$product=$_POST['product'];
$starpoints=$_POST['starpoints'];
$qty=$_POST['qty'];
$totstarpoints=$_POST['totstarpoints'];
$updatedatetime=date('Y-m-d h:i:s');




if(!empty($_POST['electrician'])){
    $electrician=$_POST['electrician'];
    $sql3="SELECT `star_points` FROM `tbl_electrician` WHERE `idtbl_electrician` = '$electrician'";
    $result3=$conn->query($sql3);
    
    
    while ($row = $result3-> fetch_assoc()) {
        $elecstarpoints=  $row['star_points'];
    }

};


if(!empty($_POST['recordID'])){$recordID=$_POST['recordID'];}
if(!empty($_POST['prevstarpoints'])){$prevstarpoints=$_POST['prevstarpoints'];
}
if(!empty($_POST['elecid'])){
    $elecid=$_POST['elecid'];
    $sql3="SELECT `star_points` FROM `tbl_electrician` WHERE `idtbl_electrician` = '$elecid'";
    $result3=$conn->query($sql3);


    while ($row = $result3-> fetch_assoc()) {
        $elecstarpoints=  $row['star_points'];
    }

};
print_r($elecstarpoints);





if($recordOption==1){
    $elecstarpoints = $elecstarpoints + $totstarpoints;
    $query = "INSERT INTO `tbl_electrician_box`(`quantity`, `totalstarpoints`, `tbl_product_idtbl_product`, `tbl_user_idtbl_user`, `tbl_electrician_idtbl_electrician`, `recieveddate`) Values ('$qty','$totstarpoints','$product','$userID','$electrician','$addeddate')";
    if($conn->query($query)==true){
        $updateelec="UPDATE `tbl_electrician` SET `star_points`='$elecstarpoints' WHERE `idtbl_electrician`='$electrician'";
        if($conn->query($updateelec)==true){
            header("Location:../electricianbox.php?action=4");

        }else{
            header("Location:../electricianbox.php?action=5");

        }

    }else{
        header("Location:../electricianbox.php?action=5");
    }
}
else{
    if($prevstarpoints == $totstarpoints){
        $update="UPDATE `tbl_electrician_box` SET `quantity`='$qty',`tbl_product_idtbl_product`='$product',`tbl_user_idtbl_user`='$userID',`tbl_electrician_idtbl_electrician`='$elecid',`recieveddate`='$addeddate',`updatedatetime`='$updatedatetime'  WHERE `idtbl_electrician_box`='$recordID'";
        if($conn->query($update)==true){     
            header("Location:../electricianbox.php?action=6");
        }
        else{header("Location:../electricianbox.php?action=5");}

    }else{
        $newstarpoints = abs($totstarpoints - $prevstarpoints);
        $update="UPDATE `tbl_electrician_box` SET `quantity`='$qty',`tbl_product_idtbl_product`='$product',`tbl_user_idtbl_user`='$userID',`tbl_electrician_idtbl_electrician`='$elecid',`recieveddate`='$addeddate',`updatedatetime`='$updatedatetime', `totalstarpoints` = '$totstarpoints'  WHERE `idtbl_electrician_box`='$recordID'";
        if($conn->query($update)==true){     
            if($prevstarpoints > $totstarpoints){
                //-
                $elecstarpoints = $elecstarpoints-$newstarpoints;

                $updateelec="UPDATE `tbl_electrician` SET `star_points`='$elecstarpoints' WHERE `idtbl_electrician`='$elecid'";
                if($conn->query($updateelec)==true){
                    header("Location:../electricianbox.php?action=4");

                }else{
                    header("Location:../electricianbox.php?action=5");

                }
            }else{
                //+
                $elecstarpoints = $elecstarpoints+$newstarpoints;
                $updateelec="UPDATE `tbl_electrician` SET `star_points`='$elecstarpoints' WHERE `idtbl_electrician`='$elecid'";
                if($conn->query($updateelec)==true){
                    header("Location:../electricianbox.php?action=4");

                }else{
                    header("Location:../electricianbox.php?action=5");

                }
            }
        }
        else{header("Location:../electricians.php?action=5");}
       
       

    }
    
}
?>