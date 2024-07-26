<?php
require_once('../connection/db.php');

$commonName = isset($_GET['common_name']) ? mysqli_real_escape_string($conn, $_GET['common_name']) : '';

if (empty($commonName)) {
    echo json_encode(array('error' => 'No common name provided'));
    exit();
}

$query = "SELECT `product_name`, `idtbl_product`, `unitprice` FROM `tbl_product` WHERE `common_name` = '$commonName' AND `status` = '1'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die(json_encode(array('error' => 'Query failed: ' . mysqli_error($conn))));
}

$products = array();
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

mysqli_close($conn);

echo json_encode($products);
?>
