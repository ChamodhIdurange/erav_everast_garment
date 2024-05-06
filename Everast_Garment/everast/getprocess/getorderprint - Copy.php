<?php
require_once('../connection/db.php');

$orderID=$_POST['orderID'];

$sqlorderdetail="SELECT * FROM `tbl_porder_detail` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_porder_detail`.`tbl_product_idtbl_product` WHERE `tbl_porder_detail`.`status`=1 AND `tbl_porder_detail`.`tbl_porder_idtbl_porder`='$orderID'";
$resultorderdetail=$conn->query($sqlorderdetail);

$sqlorder="SELECT `idtbl_porder`, `nettotal`, `remark`, `orderdate` FROM `tbl_porder` WHERE `idtbl_porder`='$orderID'";
$resultorder=$conn->query($sqlorder);
$roworder=$resultorder->fetch_assoc();

$sqlcheque="SELECT `chequeno`, `chequedate` FROM `tbl_porder_payment` WHERE `tbl_porder_idtbl_porder`='$orderID' AND `status`=1";
$resultcheque=$conn->query($sqlcheque);
$rowcheque=$resultcheque->fetch_assoc();

?>
<div class="row">
    <div class="col-3"><img src="images/logoprint.png" class="img-fluid"></div>
    <div class="col-5 small">
        <h4 class="font-weight-light m-0">Ansen Gas Distributors (Pvt) Ltd</h4>
        65, Archbishop Nicholas Marcus Fernando Mw,<br>
        Negombo<br>
        0094-31-4549149<br>
        info@ansengas.lk
    </div>
    <div class="col-4 small">
        <h4 class="font-weight-light m-0">Laugfs Gas PLC</h4>
        101 Maya Ave, Colombo 06<br>
        TP +9411 5566222<br>
        Fax +9411 5577824<br>
        Web site www.laugfsgas.lk<br>
        Email info@laugfsgas.lk
    </div>
</div>
<div class="row mt-3">
    <div class="col-12"><div class="text-center font-weight-bold bg-gray-300">Purchase Order</div></div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table table-bordered table-black bg-transparent table-sm small w-100 mt-3">
            <tr>
                <td width="15%">Date</td>
                <td width="15%"><?php echo $roworder['orderdate'] ?></td>
                <td width="15%">PO No</td>
                <td colspan="3"><?php echo 'PO-'.$roworder['idtbl_porder'] ?></td>
            </tr>
            <tr>
                <td width="15%">Notes</td>
                <td colspan="5"><?php echo $roworder['remark'] ?></td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table table-striped table-bordered table-black table-sm small bg-transparent text-center">
            <thead>
                <tr>
                    <th class="text-left" width="15%">Item Code</th>
                    <th class="text-left">Item</th>
                    <th>Type</th>
                    <th class="text-right">Unit</th>
                    <th>Qty</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while($roworderdetail=$resultorderdetail->fetch_assoc()){ ?>
                <tr>
                    <td class="text-left"><?php echo $roworderdetail['product_code']; ?></td>
                    <td class="text-left"><?php echo $roworderdetail['product_name']; ?></td>
                    <td><?php if($roworderdetail['type']==1){echo 'New';} ?></td>
                    <td class="text-right"><?php echo number_format($roworderdetail['unitprice'],2); ?></td>
                    <td><?php echo $roworderdetail['qty']; ?></td>
                    <td class="text-right"><?php echo number_format(($roworderdetail['unitprice']*$roworderdetail['qty']),2); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-6"></div>
    <div class="col-3">Gross Total</div>
    <div class="col-3 text-right"><?php echo number_format($roworder['nettotal'], 2) ?></div>
</div>
<div class="row">
    <div class="col-6"></div>
    <div class="col-3">Advanced Payment</div>
    <div class="col-3"></div>
</div>
<div class="row">
    <div class="col-9">&nbsp;</div>
    <div class="col-3"><hr class="border-dark"></div>
</div>
<div class="row">
    <div class="col-6"></div>
    <div class="col-3">Net Total</div>
    <div class="col-3 text-right"><?php echo number_format($roworder['nettotal'], 2) ?></div>
</div>
<div class="row mt-3">
    <div class="col-12">
        <h6>Cheque Information</h6>
        Cheque no: <?php echo $rowcheque['chequeno'] ?><br>
        Cheque Date : <?php echo $rowcheque['chequedate'] ?>
    </div>
</div>
<div class="row">
    <div class="col"></div>
    <div class="col-4 text-center">
        <hr class="border-dark m-0 mt-4">
        Authorized Signature
    </div>
</div>
<div class="row mt-3">
    <div class="col-12 text-center small">
        This is a system generated document
    </div>
</div>