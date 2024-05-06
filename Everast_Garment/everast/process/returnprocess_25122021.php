<?php session_start();

if( !isset($_SESSION['userid'])) {
    header ("Location:index.php");
}

require_once('../connection/db.php'); //die('bc');
$userID=$_SESSION['userid'];

$recordOption=$_POST['recordOption'];

if( !empty($_POST['recordID'])) {
    $recordID=$_POST['recordID'];
}

$returntype=$_POST['returntype'];
$product=$_POST['product'];
$qty=$_POST['qty'];
$today=date('Y-m-d');

$updatedatetime=date('Y-m-d h:i:s');

if($returntype==3 || $returntype==1 ) {
    $customer=$_POST['customer'];

    if($recordOption==1) {
        $query="INSERT INTO `tbl_return`(`returntype`, `returndate`, `qty`, `status`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_customer_idtbl_customer`, `tbl_product_idtbl_product`, `acceptance_status`) VALUES ('$returntype','$today','$qty','1','$updatedatetime','$userID','$customer','$product', '0')";

        if($conn->query($query)==true) {
            header("Location:../productreturn.php?action=4");
        }

        else {
            header("Location:../productreturn.php?action=5");
        }
    }

    else {
        $query="UPDATE `tbl_return` SET `returntype`='$returntype',`qty`='$qty',`updatedatetime`='$updatedatetime',`tbl_user_idtbl_user`='$userID',`tbl_customer_idtbl_customer`='$customer',`tbl_supplier_idtbl_supplier`='0',`tbl_product_idtbl_product`='$product' WHERE `idtbl_return`='$recordID'";

        if($conn->query($query)==true) {
            header("Location:../productreturn.php?action=6");
        }

        else {
            header("Location:../productreturn.php?action=5");
        }
    }
}

else if($returntype==2) {
    $supplier=$_POST['supplier'];

    if($recordOption==1) {
        $query="INSERT INTO `tbl_return`(`returntype`, `returndate`, `qty`, `status`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_supplier_idtbl_supplier`, `tbl_product_idtbl_product`, `acceptance_status`) VALUES ('$returntype','$today','$qty','1','$updatedatetime','$userID','$supplier','$product', '0')";

        if($conn->query($query)==true) {
            header("Location:../productreturn.php?action=4");

            // $updatestock="UPDATE `tbl_stock` SET `qty`=(`qty`-'$qty') WHERE `tbl_product_idtbl_product`='$product'";
            // if($conn->query($updatestock)==true){
            //     header("Location:../productreturn.php?action=4");
            // }        else{header("Location:../productreturn.php?action=5");}

        }

        else {
            header("Location:../productreturn.php?action=5");
        }
    }

    else {
        $query="UPDATE `tbl_return` SET `returntype`='$returntype',`qty`='$qty',`updatedatetime`='$updatedatetime',`tbl_user_idtbl_user`='$userID',`tbl_supplier_idtbl_supplier`='$supplier',`tbl_customer_idtbl_customer`='0' ,`tbl_product_idtbl_product`='$product' WHERE `idtbl_return`='$recordID'";

        if($conn->query($query)==true) {
            header("Location:../productreturn.php?action=6");
        }

        else {
            header("Location:../productreturn.php?action=5");
        }
    }
}

?>