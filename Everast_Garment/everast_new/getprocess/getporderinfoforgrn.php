<?php
require_once('../connection/db.php');

$orderID=$_POST['ponumber'];

$sqlorder="SELECT `ismaterialpo` FROM `tbl_porder` WHERE `idtbl_porder`='$orderID'";
$resultorder=$conn->query($sqlorder);
$roworder=$resultorder->fetch_assoc();

if($roworder['ismaterialpo'] == 0){
    $sqlorderdetail="SELECT `tbl_product`.`product_name`, `tbl_product`.`idtbl_product`, `tbl_porder_detail`.`unitprice`, `tbl_porder_detail`.`qty` FROM `tbl_porder_detail` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_porder_detail`.`tbl_product_idtbl_product` WHERE `tbl_porder_detail`.`status`=1 AND `tbl_porder_detail`.`tbl_porder_idtbl_porder`='$orderID'";
    $resultorderdetail=$conn->query($sqlorderdetail);
}else{
    $sqlorderdetail="SELECT `tbl_material`.`materialname`, `tbl_material`.`idtbl_material`, `tbl_porder_detail`.`unitprice`, `tbl_porder_detail`.`qty` FROM `tbl_porder_detail` LEFT JOIN `tbl_material` ON `tbl_material`.`idtbl_material`=`tbl_porder_detail`.`tbl_material_idtbl_material` WHERE `tbl_porder_detail`.`status`=1 AND `tbl_porder_detail`.`tbl_porder_idtbl_porder`='$orderID'";
    $resultorderdetail=$conn->query($sqlorderdetail);
}

while ($roworderdetail = $resultorderdetail-> fetch_assoc()) {
    $totnew=$roworderdetail['qty']*$roworderdetail['unitprice'];

    $total=$totnew;
?>
<tr>
    <?php if($roworder['ismaterialpo'] == 0){ ?>
    <td><?php echo $roworderdetail['product_name'] ?></td>
    <td class="d-none"><?php echo $roworderdetail['idtbl_product'] ?></td>
    <?php }else{?>
    <td><?php echo $roworderdetail['materialname'] ?></td>
    <td class="d-none"><?php echo $roworderdetail['idtbl_material'] ?></td>
    <?php }?>
    <td class="d-none"><?php echo $roworderdetail['unitprice'] ?></td>
    <td class="text-right"><?php echo number_format($roworderdetail['unitprice'],2) ?></td>
    <td class="text-center editnewqty"><?php echo $roworderdetail['qty'] ?></td>
    <td class="total d-none"><?php echo $total ?></td>
    <td class="text-right"><?php echo number_format($total,2) ?></td>
</tr>
<?php } ?>