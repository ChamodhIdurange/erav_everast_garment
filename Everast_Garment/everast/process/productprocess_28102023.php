<?php
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('../connection/db.php');//die('bc');
$userID=$_SESSION['userid'];

$recordOption=$_POST['recordOption'];
if(!empty($_POST['recordID'])){$recordID=$_POST['recordID'];}
$product_name = $_POST['productName'];
$productcode = $_POST['productcode'];
$unitprice = $_POST['unitprice'];
$saleprice = $_POST['saleprice'];
$category = $_POST['category'];

$supplier = $_POST['supplier'];
$subcategory = $_POST['subcategory'];
$groupcategory = $_POST['groupcategory'];
$rol = $_POST['rol'];
$barcode = $_POST['barcode'];
$retail = $_POST['retail'];
$peices = $_POST['peices'];
$starpoints = $_POST['starpoints'];

$commonname = $_POST['commonname'];
$size = $_POST['size'];
$sizecategory = $_POST['sizecategory'];


$salediscount = $_POST['salediscount'];
$retaildiscount = $_POST['retaildiscount'];
$priceradio = $_POST['priceradio'];

if(!empty($_POST['additionaldiscount'])){
    $additionaldiscount=$_POST['additionaldiscount'];
}else{
    $additionaldiscount=0;
}

$updatedatetime=date('Y-m-d h:i:s');
$today=date('Y-m-d');

if($recordOption==1){
    $query = "INSERT INTO `tbl_product`(`product_code`, `product_name`, `size`, `unitprice`, `saleprice`, `status`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_product_category_idtbl_product_category`, `barcode`, `rol`, `pices_per_box`, `retail`, `starpoints`, `tbl_group_category_idtbl_group_category`, `tbl_sub_product_category_idtbl_sub_product_category`, `tbl_supplier_idtbl_supplier`, `retaildiscount`, `salediscount`, `price_acceptable`, `additional_discount`, `common_name`, `tbl_sizes_idtbl_sizes`, `tbl_size_categories_idtbl_size_categories`) Values ('$productcode','$product_name','','$unitprice','$saleprice','1','$updatedatetime','$userID','$category','$barcode','$rol','$peices','$retail','$starpoints','$groupcategory','$subcategory','$supplier','$retaildiscount','$salediscount', '$priceradio', '$additionaldiscount', '$commonname', '$size', '$sizecategory')";
    if($conn->query($query)==true){
        $productID=$conn->insert_id;

        $insertstock="INSERT INTO `tbl_stock`(`qty`, `update`, `status`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_product_idtbl_product`) VALUES ('0','$today','1','$updatedatetime','$userID','$productID')";
        $conn->query($insertstock);

        $sqlcuslist="SELECT `idtbl_customer` FROM `tbl_customer` WHERE `type` IN (2) AND `status` IN (1, 2)";
        $resultcuslist=$conn->query($sqlcuslist);
        while ($rowcuslist = $resultcuslist-> fetch_assoc()) {
            $customerID=$rowcuslist['idtbl_customer'];

            $insertproductsale="INSERT INTO `tbl_customer_product`(`saleprice`, `status`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_product_idtbl_product`, `tbl_customer_idtbl_customer`) VALUES ('$saleprice','1','$updatedatetime','$userID','$productID','$customerID')";
            $conn->query($insertproductsale);
        }

        header("Location:../product.php?action=4");
    }
    else{header("Location:../product.php?action=5");}
}
else{
    $query = "UPDATE `tbl_product` SET `product_code`='$productcode',`product_name`='$product_name',`unitprice`='$unitprice',`saleprice`='$saleprice',`updatedatetime`='$updatedatetime',`tbl_user_idtbl_user`='$userID', `tbl_product_category_idtbl_product_category`='$category',`barcode`='$barcode',`rol`='$rol',`pices_per_box`='$peices',`retail`='$retail',`starpoints`='$starpoints',`tbl_sub_product_category_idtbl_sub_product_category`='$subcategory',`tbl_group_category_idtbl_group_category`='$groupcategory',`tbl_supplier_idtbl_supplier`='$supplier',`retaildiscount`='$retaildiscount',`salediscount`='$salediscount', `price_acceptable` = '$priceradio', `additional_discount` = '$additionaldiscount', `common_name` = '$commonname', `tbl_sizes_idtbl_sizes` = '$size', `tbl_size_categories_idtbl_size_categories` = '$sizecategory'  WHERE `idtbl_product`='$recordID'";
    if($conn->query($query)==true){
        $sqlcuslist="SELECT `idtbl_customer` FROM `tbl_customer` WHERE `type` IN (2) AND `status` IN (1, 2)";
        $resultcuslist=$conn->query($sqlcuslist);
        while ($rowcuslist = $resultcuslist-> fetch_assoc()) {
            $customerID=$rowcuslist['idtbl_customer'];

            $updateproductsale="UPDATE `tbl_customer_product` SET `saleprice`='$saleprice',`updatedatetime`='$updatedatetime',`tbl_user_idtbl_user`='$userID' WHERE `tbl_product_idtbl_product`='$recordID' AND `tbl_customer_idtbl_customer`='$customerID'";
            $conn->query($updateproductsale);
        }

        header("Location:../product.php?action=6");
    }
    else{header("Location:../product.php?action=5");}
}
?>