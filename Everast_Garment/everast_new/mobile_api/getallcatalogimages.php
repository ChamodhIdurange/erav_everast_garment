<?php

require_once('dbConnect.php');

//$id=$_POST['idtbl_catalog_category'];


$sql="SELECT `tbl_product_image`.`idtbl_product_image`, `tbl_product_image`.`imagepath`, `tbl_product_image`.`tbl_catalog_idtbl_catalog`, `tbl_catalog_category`.`category` FROM `tbl_product_image` LEFT JOIN  `tbl_catalog` ON `tbl_catalog`.`idtbl_catalog`=`tbl_product_image`.`tbl_catalog_idtbl_catalog` LEFT JOIN `tbl_catalog_category` ON `tbl_catalog_category`.`idtbl_catalog_category`=`tbl_catalog`.`tbl_catalog_category_idtbl_catalog_category` WHERE `tbl_catalog`.`status`=1";
$res = mysqli_query($con, $sql);
$result = array();

while ($row = mysqli_fetch_array($res)) {
    array_push($result, array( "id" => $row['idtbl_product_image'], "path" => $row['imagepath'], "catalog_id" => $row['tbl_catalog_idtbl_catalog'],  "category" => $row['category']));
}

print(json_encode($result));
mysqli_close($con);
