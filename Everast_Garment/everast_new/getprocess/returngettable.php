<?php
require_once('../connection/db.php');

session_start();
$invoiceId = $_POST['invoiceId'];

$sql = "SELECT `d`.`tbl_product_idtbl_product`, `d`.`idtbl_invoice_detail`, `p`.`product_name`, `d`.`saleprice`, `d`.`qty` FROM `tbl_invoice` AS `i` LEFT JOIN `tbl_invoice_detail` AS `d` ON (`i`.`idtbl_invoice` = `d`.`tbl_invoice_idtbl_invoice`) LEFT JOIN `tbl_product` AS `p` ON (`p`.`idtbl_product` = `d`.`tbl_product_idtbl_product`) WHERE `i`.`idtbl_invoice` = '$invoiceId'";
$result = $conn->query($sql);
?>
 <small id="" class="form-text text-danger">Select and Enter Return Quantity</small>
<table class="table table-hover small" id="tablereturnamount">
    <thead>
        <tr>
            <th class="d-none">#</th>
            <th class="d-none">Product Id</th>
            <th class="d-none">Detail Id</th>
            <th>Product</th>
            <th>Sale Price</th>
            <th>Qty</th>
            <th>Return Qty</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

        <?php
        while ($rowresult = $result->fetch_assoc()) { ?>
            <tr>
                <td class="d-none"><?php echo $rowresult['idtbl_invoice']; ?></td>
                <td class="d-none"><?php echo $rowresult['tbl_product_idtbl_product']; ?></td>
                <td class="d-none"><?php echo $rowresult['idtbl_invoice_detail']; ?></td>

                <td class=""><?php echo $rowresult['product_name']; ?></td>
                <td class=""><?php echo number_format($rowresult['saleprice'], 2); ?></td>
                <td class=""><?php echo $rowresult['qty']; ?></td>
                <td class=""><input type = "text" name="editqtyreturn" value="0"></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

