<?php
require_once('connection/db.php');
// 2021-12-09
$updatedatetime=date('Y-m-d h:i:s');
$userID=1;
// $filename='customers.csv';

// $file = fopen($filename, 'r');
// $i=0;
// while (($line = fgetcsv($file)) !== FALSE) {
//     print_r($line);
//     $name=addslashes($line[0]);
//     $type=$line[1];
//     $nic=$line[2];
//     $area=$line[3];
//     $mobile=addslashes($line[4]);
//     $address=addslashes($line[5]);
//     $vat=$line[6];
//     $svat=$line[7];
//     $email=$line[8];
//     $credittype=$line[13];
//     $creditlimit=$line[14];
    
//     $query = "INSERT INTO `tbl_customer`(`type`, `name`, `nic`, `phone`, `email`, `address`, `vat_num`, `s_vat`, `numofvisitdays`, `creditlimit`, `credittype`, `creditperiod`, `emergencydate`, `status`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_area_idtbl_area`) VALUES ('$type', '$name', '$nic', '$mobile', '$email', '$address', '$vat', '$svat', '', '$creditlimit','$credittype','','','1','$updatedatetime', '$userID', '$area')";
//     $conn->query($query);
// }
// fclose($file);

// $sqlproduct="SELECT `tbl_product`.`idtbl_product`, `tbl_product`.`product_name`, `tbl_product_category`.`category` FROM `tbl_product` LEFT JOIN `tbl_product_category` ON `tbl_product_category`.`idtbl_product_category`=`tbl_product`.`tbl_product_category_idtbl_product_category` WHERE `tbl_product`.`status`=1";
// $resultproduct =$conn-> query($sqlproduct); 
// while($rowproduct=$resultproduct->fetch_assoc()){
//     $productID=$rowproduct['idtbl_product'];
//     $productname=$rowproduct['product_name'].'-'.$rowproduct['category'];

//     $updateproduct="UPDATE `tbl_product` SET `product_name`='$productname' WHERE `idtbl_product`='$productID'";
//     $conn->query($updateproduct);
// }

// 2021-12-20

// $filename='electricians.csv';

// $file = fopen($filename, 'r');
// $i=0;
// while (($line = fgetcsv($file)) !== FALSE) {
//     print_r($line);
//     $name=addslashes($line[0]);
//     $contact=$line[1];
//     $area=1;
//     $customer=1;
//     $points=$line[9];
    
//     $query = "INSERT INTO `tbl_electrician`(`name`, `tbl_area_idtbl_area`, `tbl_customer_idtbl_customer`, `contact`, `star_points`, `updatedatetime`, `tbl_user_idtbl_user`, `status`) VALUES ('$name','$area','$customer','$contact','$points','$updatedatetime','$userID','1')";
//     $conn->query($query);
// }
// fclose($file);

// 2021-12-2

// $filename='cutomarea.csv';

// $file = fopen($filename, 'r');
// $i=0;
// while (($line = fgetcsv($file)) !== FALSE) {
//     print_r($line);
//     $cusID=$line[0];
//     $areaID=$line[2];
    
//     $query = "UPDATE `tbl_customer` SET `tbl_area_idtbl_area`='$areaID' WHERE `idtbl_customer`='$cusID'";
//     $conn->query($query);
// }
// fclose($file);

// 2022-01-03

// $filename='productlist.csv';

// $file = fopen($filename, 'r');
// $i=0;
// while (($line = fgetcsv($file)) !== FALSE) {
//     print_r($line);
//     $supID=$line[0];
//     $product=$line[1];
//     $productcode=$line[2];
//     $barcode=$line[3];
//     $unit=$line[4];
//     $sale=$line[5];
//     $maincate=$line[6];
//     $subcate=$line[7];
//     $groupcate=$line[8];
//     $rol=$line[9];
//     $pices=$line[10];
//     $retail=$line[11];
//     $saledis=$line[12];
//     $retaildis=$line[13];
//     $star=$line[14];
    
//     $query = "INSERT INTO `tbl_product`(`product_code`, `barcode`, `product_name`, `size`, `unitprice`, `saleprice`, `rol`, `pices_per_box`, `retail`, `salediscount`, `retaildiscount`, `price_acceptable`, `additional_discount`, `starpoints`, `status`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_product_category_idtbl_product_category`, `tbl_group_category_idtbl_group_category`, `tbl_sub_product_category_idtbl_sub_product_category`, `tbl_supplier_idtbl_supplier`) VALUES ('$productcode','$barcode','$product','','$unit','$sale','$rol','$pices','$retail','$saledis','$retaildis','','','$star','1','$updatedatetime','$userID','$maincate','$groupcate','$subcate','$supID')";
//     $conn->query($query);
// }
// fclose($file);

