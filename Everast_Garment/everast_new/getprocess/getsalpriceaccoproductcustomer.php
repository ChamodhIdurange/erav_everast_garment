<?php
require_once('../connection/db.php');

$productID=$_POST['productID'];
$customerID=$_POST['customerID'];
$customerType=$_POST['customerType'];

$sqlproductcustomer="SELECT `c`.`saleprice` FROM `tbl_customer_product` AS `c` WHERE `c`.`status`=1 AND `c`.`tbl_product_idtbl_product`='$productID' AND `c`.`tbl_customer_idtbl_customer`='$customerID'";
$resultproductcustomer=$conn->query($sqlproductcustomer);
$rowproductcustomer=$resultproductcustomer->fetch_assoc();

if($resultproductcustomer-> num_rows > 0) {
    $sqlproduct="SELECT `p`.`saleprice`, `p`.`unitprice`, `p`.`retail`  FROM `tbl_product` AS `p` WHERE `p`.`idtbl_product`='$productID'";
    $resultproduct=$conn->query($sqlproduct);
    $rowproduct=$resultproduct->fetch_assoc();

    $obj=new stdClass();
    if($customerType == 1){
        $obj->saleprice=$rowproduct['retail'];
    }else{
        $obj->saleprice=$rowproduct['saleprice'];
    }
    $obj->unitprice=$rowproduct['unitprice'];
    $obj->suppliername='';
}
else{
    $sqlproduct="SELECT `p`.`saleprice`, `p`.`unitprice`, `p`.`retail`, `s`.`suppliername`, `m`.`name` FROM `tbl_product` AS `p` LEFT JOIN `tbl_supplier` AS `s` ON (`p`.`tbl_supplier_idtbl_supplier` = `s`.`idtbl_supplier`)  LEFT JOIN `tbl_sizes` AS `m` ON (`p`.`tbl_sizes_idtbl_sizes` = `m`.`idtbl_sizes`) WHERE `p`.`idtbl_product`='$productID'";
    $resultproduct=$conn->query($sqlproduct);
    $rowproduct=$resultproduct->fetch_assoc();

    if($resultproduct-> num_rows > 0) {
        $obj=new stdClass();
        if($customerType == 1){
            $obj->saleprice=$rowproduct['retail'];
        }else{
            $obj->saleprice=$rowproduct['saleprice'];
        }
        $obj->unitprice=$rowproduct['unitprice'];
        $obj->suppliername=$rowproduct['suppliername'];
        $obj->commonname=$rowproduct['name'];

    }
    else{
        $obj=new stdClass();
        $obj->saleprice='0';
        $obj->unitprice='0';
        $obj->suppliername='';
        $obj->commonname='';
    echo 'qweqwewq';

    }
}
echo json_encode($obj);
?>