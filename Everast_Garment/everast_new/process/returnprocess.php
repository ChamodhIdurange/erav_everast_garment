<?php session_start();

if (!isset($_SESSION['userid'])) {
    header("Location:index.php");
}

require_once('../connection/db.php'); //die('bc');
$userID = $_SESSION['userid'];

$recordOption = $_POST['recordOption'];
$updatedatetime = date('Y-m-d h:i:s');

if ($recordOption == 1) {

    if (!empty($_POST['recordID'])) {
        $recordID = $_POST['recordID'];
    }

    $tableData = $_POST['tableData'];

    $returntype = $_POST['returntype'];
    $asm = $_POST['asm'];
    $total = $_POST['total'];

    $today = date('Y-m-d');

    if ($returntype == 3 || $returntype == 1) {
        $customer = $_POST['customer'];


        if ($returntype == 1) {
            $remarks = $_POST['remarks'];
            $query = "INSERT INTO `tbl_return`(`tbl_employee_idtbl_employee`, `returntype`, `returndate`, `status`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_customer_idtbl_customer`, `acceptance_status`, `total`, `damaged_reason`) VALUES ('$asm', '$returntype','$today','1','$updatedatetime','$userID','$customer', '0', '$total', '$remarks')";
        } else if ($returntype == 3) {
            $remarks = $_POST['remarks'];

            $query = "INSERT INTO `tbl_return`(`tbl_employee_idtbl_employee`, `returntype`, `returndate`, `status`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_customer_idtbl_customer`, `acceptance_status`, `total`, `damaged_reason`) VALUES ('$asm', '$returntype','$today','1','$updatedatetime','$userID','$customer', '0', '$total', '$remarks')";
        }
        if ($conn->query($query) == true) {
            $last_id = mysqli_insert_id($conn);

            foreach ($tableData as $rowtabledata) {
                $productID = $rowtabledata['col_1'];
                $unitprice = $rowtabledata['col_3'];
                $qty = $rowtabledata['col_4'];
                $discount = $rowtabledata['col_5'];
                $subtotal = $rowtabledata['col_6'];

                $insertreturndetails = "INSERT INTO `tbl_return_details`(`unitprice`, `qty`, `discount`, `tbl_product_idtbl_product`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_return_idtbl_return`,`total`) VALUES ('$unitprice','$qty','$discount','$productID','$updatedatetime','$userID','$last_id','$subtotal')";
                $conn->query($insertreturndetails);
            }
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-check-circle';
            $actionObj->title = '';
            $actionObj->message = 'Add Successfully';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'success';

            echo $actionJSON = json_encode($actionObj);
        } else {
            header("Location:../productreturn.php?action=5");
        }
    } else if ($returntype == 2) {
        $supplier = $_POST['supplier'];


        $query = "INSERT INTO `tbl_return`(`tbl_employee_idtbl_employee`, `returntype`, `returndate`, `status`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_supplier_idtbl_supplier`, `acceptance_status`, `total`) VALUES ('$asm', '$returntype','$today','1','$updatedatetime','$userID','$supplier', '0', '$total')";

        if ($conn->query($query) == true) {
            $last_id = mysqli_insert_id($conn);

            foreach ($tableData as $rowtabledata) {
                $productID = $rowtabledata['col_1'];
                $unitprice = $rowtabledata['col_3'];
                $qty = $rowtabledata['col_4'];
                $discount = $rowtabledata['col_5'];
                $subtotal = $rowtabledata['col_6'];

                $insertreturndetails = "INSERT INTO `tbl_return_details`(`unitprice`, `qty`, `discount`, `tbl_product_idtbl_product`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_return_idtbl_return`, `total`) VALUES ('$unitprice','$qty','$discount','$productID','$updatedatetime','$userID','$last_id', '$subtotal')";
                $conn->query($insertreturndetails);
            }
            header("Location:../productreturn.php?action=4");
        } else {
            header("Location:../productreturn.php?action=5");
        }


        // else {
        //     $query="UPDATE `tbl_return` SET `returntype`='$returntype',`qty`='$qty',`updatedatetime`='$updatedatetime',`tbl_user_idtbl_user`='$userID',`tbl_supplier_idtbl_supplier`='$supplier',`tbl_customer_idtbl_customer`='0' ,`tbl_product_idtbl_product`='$product' WHERE `idtbl_return`='$recordID'";

        //     if($conn->query($query)==true) {
        //         header("Location:../productreturn.php?action=6");
        //     }

        //     else {
        //         header("Location:../productreturn.php?action=5");
        //     }
        // }
    }
} else {
    $unitprice = $_POST['unitprice'];
    $record = $_POST['hiddenid'];
    $discount = $_POST['discount'];
    $qty = $_POST['qty'];
    $prevtot = $_POST['hiddentotal'];
    $hiddendiscount = $_POST['hiddendiscount'];
    $total = $_POST['total'];
    $mainID = $_POST['mainID'];
    $returntype = $_POST['returntype'];

    $tot = $total - ($total * ($discount / 100));

    if ($prevtot !=  $total || $hiddendiscount != $discount) {

        $query = "UPDATE `tbl_return_details` SET `qty`='$qty',`discount`='$discount', `total`='$tot',`updatedatetime`='$updatedatetime',`tbl_user_idtbl_user`='$userID' WHERE `idtbl_return_details`='$record'";

        if ($conn->query($query) == true) {

            $query1 = "UPDATE `tbl_return` SET `total`=(`total` - '$prevtot' + '$tot') WHERE `idtbl_return`='$mainID'";

            if ($conn->query($query1) == true) {
                if ($returntype == 1) {
                    header("Location:../customerreturn.php?action=6");
                } else if ($returntype == 2) {
                    header("Location:../supplierreturn.php?action=6");
                } else {
                    header("Location:../damagereturns.php?action=6");
                }
            } else {
                if ($returntype == 1) {
                    header("Location:../customerreturn.php?action=5");
                } else if ($returntype == 2) {
                    header("Location:../supplierreturn.php?action=5");
                } else {
                    header("Location:../damagereturns.php?action=5");
                }
            }
        } else {
        }
    } else {
        if ($returntype == 1) {
            header("Location:../customerreturn.php");
        } else if ($returntype == 2) {
            header("Location:../supplierreturn.php");
        } else {
            header("Location:../damagereturns.php");
        }
    }
}
