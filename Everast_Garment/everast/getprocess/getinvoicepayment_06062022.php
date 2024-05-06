<?php 
require_once('../connection/db.php');

if(!empty($_POST['invoiceno'])){
    $invoiceno=$_POST['invoiceno'];
    $invoiceID=substr($invoiceno, 4);

    $sql="SELECT `tbl_employee`.`name` as `asm`, `tbl_invoice`.`idtbl_invoice`, `tbl_invoice`.`paymentcomplete`, `tbl_invoice`.`date`, `tbl_invoice`.`total`, `tbl_invoice_payment_has_tbl_invoice`.`payamount` FROM `tbl_invoice` LEFT JOIN `tbl_invoice_payment_has_tbl_invoice` ON `tbl_invoice_payment_has_tbl_invoice`.`tbl_invoice_idtbl_invoice`=`tbl_invoice`.`idtbl_invoice` LEFT JOIN `tbl_employee` ON (`tbl_employee`.`idtbl_employee` = `tbl_invoice`.`ref_id`) WHERE `tbl_invoice`.`idtbl_invoice`='$invoiceID' AND `tbl_invoice`.`status`=1 AND `tbl_invoice`.`paymentcomplete`=0 AND `tbl_invoice`.`payment_created` IN (0,1)  Group BY `tbl_invoice`.`idtbl_invoice`";
    $result=$conn->query($sql);
}
else if(!empty($_POST['customerID'])){
    $customerID=$_POST['customerID'];

    $sql="SELECT `tbl_employee`.`name` as `asm`, `tbl_invoice`.`idtbl_invoice`, `tbl_invoice`.`paymentcomplete`, `tbl_invoice`.`date`, `tbl_invoice`.`total`, `tbl_invoice_payment_has_tbl_invoice`.`payamount` FROM `tbl_invoice` LEFT JOIN `tbl_invoice_payment_has_tbl_invoice` ON `tbl_invoice_payment_has_tbl_invoice`.`tbl_invoice_idtbl_invoice`=`tbl_invoice`.`idtbl_invoice` LEFT JOIN `tbl_employee` ON `tbl_employee`.`idtbl_employee` = `tbl_invoice`.`ref_id` WHERE `tbl_invoice`.`tbl_customer_idtbl_customer`='$customerID' AND `tbl_invoice`.`status`=1 AND `tbl_invoice`.`paymentcomplete`=0 AND `tbl_invoice`.`payment_created` IN (0,1)  Group BY `tbl_invoice`.`idtbl_invoice`";
    $result=$conn->query($sql);
}
else if(!empty($_POST['asm'])){
    $asmID=$_POST['asm'];

    $sql="SELECT `tbl_employee`.`name` as `asm`, `tbl_invoice`.`idtbl_invoice`, `tbl_invoice`.`paymentcomplete`, `tbl_invoice`.`date`, `tbl_invoice`.`total`, `tbl_invoice_payment_has_tbl_invoice`.`payamount` FROM `tbl_invoice` LEFT JOIN `tbl_invoice_payment_has_tbl_invoice` ON `tbl_invoice_payment_has_tbl_invoice`.`tbl_invoice_idtbl_invoice`=`tbl_invoice`.`idtbl_invoice` LEFT JOIN `tbl_employee` ON (`tbl_employee`.`idtbl_employee` = `tbl_invoice`.`ref_id`) WHERE `tbl_invoice`.`ref_id`='$asmID' AND `tbl_invoice`.`status`=1 AND `tbl_invoice`.`paymentcomplete`=0 AND `tbl_invoice`.`payment_created` IN (0,1)  Group BY `tbl_invoice`.`idtbl_invoice`";
    $result=$conn->query($sql);
}
?>
<table class="table table-striped table-bordered table-sm" id="paymentDetailTable">
    <thead>
        <tr>
            <th>Invoice No</th>
            <th>ASM/CSM</th>
            <th class="d-none">Sale Type</th>
            <th>Date</th>
            <th class="text-right">Amount</th>
            <th class="text-right">Paid Amount</th>
            <th class="text-right">Balance</th>
            <!-- <th>Cash On Delivery</th>
            <th>For PDs</th> -->
            <th>Full Payment</th>
            <th>Half Payment</th>
            <th class="">Payment</th>
            <th class="d-none">Collect Type</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row=$result->fetch_assoc()){ ?>
        <tr>
            <td><?php echo 'INV-'.$row['idtbl_invoice']; ?></td>
            <td><?php echo 'INV-'.$row['asm']; ?></td>
            <td class="d-none">&nbsp;</td>
            <td><?php echo $row['date']; ?></td>
            <td class="text-right"><?php echo sprintf('%.2f', $row['total']); ?></td>
            <td class="text-right"><?php echo sprintf('%.2f', $row['payamount']); ?></td>
            <td class="text-right"><?php echo sprintf('%.2f', ($row['total']-$row['payamount'])); ?></td>
            <td>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input fullAmount" name="payCheck1" id="payCheck1<?php echo $row['idtbl_invoice']; ?>" value="1" <?php if($row['payamount']>0){echo 'disabled';} ?>>
                    <label class="custom-control-label small" for="payCheck1<?php echo $row['idtbl_invoice']; ?>">Full Payment</label>
                </div>
            </td>
            <td>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input halfAmount" name="payCheck2" id="payCheck2<?php echo $row['idtbl_invoice']; ?>">
                    <label class="custom-control-label small" for="payCheck2<?php echo $row['idtbl_invoice']; ?>">Half Payment</label>
                </div>
            </td>
            <td class='paidAmount text-right'>0.00</td>
            <td class='d-none'>0</td>
            
        </tr>
        <?php } ?>
    </tbody>
</table>