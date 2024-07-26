<?php
require_once('../connection/db.php');

$orderID=$_POST['ponumber'];

$sqlvat = "SELECT `idtbl_vat_info`, `vat` FROM `tbl_vat_info` ORDER BY `idtbl_vat_info` DESC LIMIT 1";
$resultvat = $conn->query($sqlvat);
$rowvat = $resultvat->fetch_assoc();

$sqlorderdetail="SELECT `tbl_porder_detail`.`unitprice`,`tbl_porder_detail`.`qty`,`tbl_product`.`product_name`,`tbl_product`.`idtbl_product` FROM `tbl_porder_detail` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_porder_detail`.`tbl_product_idtbl_product` WHERE `tbl_porder_detail`.`status`=1 AND `tbl_porder_detail`.`tbl_porder_idtbl_porder`='$orderID'";
$resultorderdetail=$conn->query($sqlorderdetail);
while ($roworderdetail = $resultorderdetail-> fetch_assoc()) {
    $totrefill=$roworderdetail['qty']*$roworderdetail['unitprice'];
?>
<tr>
    <td><?php echo $roworderdetail['product_name'] ?></td>
    <td class="d-none"><?php echo $roworderdetail['idtbl_product'] ?></td>
    <td class="d-none"><?php echo $roworderdetail['unitprice'] ?></td>
    <td class="text-right"><?php echo number_format($roworderdetail['unitprice'],2) ?></td>
    <td class="text-center editnewqty"><?php echo $roworderdetail['qty'] ?></td>
    <td class="total d-none"><?php echo $totrefill ?></td>
    <!-- <td class="text-center"><?php //echo $rowvat['vat']. '%' ?></td> -->
    <td class="text-right"><?php echo number_format($totrefill,2) ?></td>
</tr>
<?php } ?>