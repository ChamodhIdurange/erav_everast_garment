<?php
require_once('../connection/db.php');

$record=$_POST['recordID'];

$sql="SELECT * FROM `tbl_product` WHERE `idtbl_product`='$record'";
$result=$conn->query($sql);
$row=$result->fetch_assoc();

$obj=new stdClass();
$obj->id=$row['idtbl_product'];
$obj->product_name=$row['product_name'];
$obj->productcode=$row['product_code'];
$obj->unitprice=$row['unitprice'];
$obj->saleprice=$row['saleprice'];
$obj->barcode=$row['barcode'];
$obj->rol=$row['rol'];
$obj->pices_per_box=$row['pices_per_box'];
$obj->retail=$row['retail'];
$obj->maxdiscount=$row['maxdiscount'];
$obj->starpoints=$row['starpoints'];
$obj->category=$row['tbl_product_category_idtbl_product_category'];
$obj->groupcategory=$row['tbl_group_category_idtbl_group_category'];
$obj->subcategory=$row['tbl_sub_product_category_idtbl_sub_product_category'];
$obj->supplier=$row['tbl_supplier_idtbl_supplier'];


echo json_encode($obj);
?>