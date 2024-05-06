<?php 
require_once('../connection/db.php');

$validfrom=$_POST['validfrom'];
$validto=$_POST['validto'];
$customer=$_POST['customer'];

if(!empty($_POST['customer'])){
    $sqlcustomer="SELECT `idtbl_customer`, `name` FROM `tbl_customer` WHERE `status`=1 AND `idtbl_customer`='$customer'";
    $resultcustomer =$conn-> query($sqlcustomer);
}
else{
    $sqlcustomer="SELECT `idtbl_customer`, `name` FROM `tbl_customer` WHERE `status`=1";
    $resultcustomer =$conn-> query($sqlcustomer);
}
?>
<table class="table table-striped table-bordered table-sm" id="tableoutstanding">
    <thead>
        <tr>
            <th>Customer</th>
            <th>Product</th>
            <th class="text-center">New Qty</th>
            <th class="text-center">Refill Qty</th>
            <th class="text-center">Trust Qty</th>
            <th class="text-center">Total Qty</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        while($rowcustomer = $resultcustomer-> fetch_assoc()){ 
            $customerID=$rowcustomer['idtbl_customer'];

            $sqlinvcount="SELECT COUNT(*) AS `count` FROM `tbl_invoice` WHERE `status`=1 AND `tbl_customer_idtbl_customer`='$customerID' AND `date` BETWEEN '$validfrom' AND '$validto'";
            $resultinvcount =$conn-> query($sqlinvcount);
            $rowinvcount = $resultinvcount-> fetch_assoc();

            $sqlproductlist="SELECT `idtbl_product`, `product_name` FROM `tbl_product` WHERE `status`=1 AND `tbl_product_category_idtbl_product_category`=1";
            $resultproductlist =$conn-> query($sqlproductlist);

            if($rowinvcount['count']>0){
        ?>
        <tr>
            <td colspan="7"><?php echo $rowcustomer['name']; ?></td>
        </tr>
        <?php 
            while($rowproductlist = $resultproductlist-> fetch_assoc()){  
                $productID=$rowproductlist['idtbl_product'];

                $sqlsaleinfo="SELECT SUM(`newqty`) AS `newqty`, SUM(`refillqty`) AS `refillqty`, SUM(`trustqty`) AS `trustqty` FROM `tbl_invoice_detail` WHERE `tbl_product_idtbl_product`='$productID' AND `status`=1 AND `tbl_invoice_idtbl_invoice` IN (SELECT `idtbl_invoice` FROM `tbl_invoice` WHERE `status`=1 AND `tbl_customer_idtbl_customer`='$customerID' AND `date` BETWEEN '$validfrom' AND '$validto')";
                $resultsaleinfo =$conn-> query($sqlsaleinfo);
                $rowsaleinfo = $resultsaleinfo-> fetch_assoc()
        ?>
        <tr>
            <td>&nbsp;</td>
            <td><?php echo $rowproductlist['product_name'] ?></td>
            <td class="text-center"><?php echo $rowsaleinfo['newqty']; ?></td>
            <td class="text-center"><?php echo $rowsaleinfo['refillqty']; ?></td>
            <td class="text-center"><?php echo $rowsaleinfo['trustqty'] ?></td>
            <th class="text-center"><?php echo $rowsaleinfo['newqty']+$rowsaleinfo['refillqty']+$rowsaleinfo['trustqty'] ?></th>
        </tr>
        <?php }}} ?>
    </tbody>
</table>