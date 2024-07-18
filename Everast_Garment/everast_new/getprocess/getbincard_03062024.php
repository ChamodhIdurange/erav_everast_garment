<?php
session_start();
require_once('../connection/db.php');

$item = $_POST['item'];

$sqlgrn = "SELECT * FROM (
    SELECT 
        `grn`.`idtbl_grndetail` AS `id`,
        `grn`.`qty` AS `quantity`,
        `grnmain`.`date` AS `date`,
        'GRN' AS `source`
    FROM 
        `tbl_grndetail` AS `grn` 
    LEFT JOIN 
        `tbl_grn` AS `grnmain` 
    ON 
        (`grnmain`.`idtbl_grn` = `grn`.`tbl_grn_idtbl_grn`) 
    WHERE 
        `grn`.`tbl_product_idtbl_product` = '$item'
    
    UNION
    
    SELECT 
        `stk`.`idtbl_stock` AS `id`,
        `stk`.`qty` AS `quantity`,
        `stk`.`update` AS `date`,
        'Stock' AS `source`
    FROM 
        `tbl_stock` AS `stk` 
    WHERE 
        `stk`.`tbl_product_idtbl_product` = '$item'
    
    UNION
    
    SELECT 
        `po`.`idtbl_porder_detail` AS `id`,
        `po`.`qty` AS `quantity`,
        `porder`.`orderdate` AS `date`,
        'Purchase Order' AS `source`
    FROM 
        `tbl_porder_detail` AS `po` 
    LEFT JOIN 
        `tbl_porder` AS `porder` 
    ON 
        (`porder`.`idtbl_porder` = `po`.`tbl_porder_idtbl_porder`) 
    WHERE 
        `po`.`tbl_product_idtbl_product` = '$item'
        AND `porder`.`potype` = '1'
    
    UNION
    
    SELECT 
        `rt`.`idtbl_return_details` AS `id`,
        `rt`.`qty` AS `quantity`,
        `rtn`.`returndate` AS `date`,
        'Return' AS `source`
    FROM 
        `tbl_return_details` AS `rt` 
    LEFT JOIN 
        `tbl_return` AS `rtn` 
    ON 
        (`rtn`.`idtbl_return` = `rt`.`tbl_return_idtbl_return`) 
    WHERE 
        `rt`.`tbl_product_idtbl_product` = '$item' 
        AND `rtn`.`acceptance_status` = '1'
) AS combined
ORDER BY `date` ASC;
";

$resultgrn = $conn->query($sqlgrn);
if (!$resultgrn) {
    echo "Error: " . $conn->error;
    exit;
}
$sumgrn = 0;
$availstock = 0;
$sumstock = 0;
$sumpo = 0;
$sumponew = 0;
$newpo = 0;
$sumrtn = 0;
$newpostk = 0;
$sumstockqty = 0;
$sumgrnqty = 0;
$poqty = 0;
$sumrtnqty = 0;
?>
<style>
    .circle1 {
        width: 10px;
        height: 10px;
        background-color: #ffc107;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 4px;
    }
    .circle2 {
        width: 10px;
        height: 10px;
        background-color: #28a745;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 4px;
    }
    .circle3 {
        width: 10px;
        height: 10px;
        background-color: #007bff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 4px;
    }
    .circle4 {
        width: 10px;
        height: 10px;
        background-color: #dc3545;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 4px;
    }
    .circle5 {
        width: 10px;
        height: 10px;
        background-color: #343a40;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 4px;
    }
    .txt{
        margin-left: 4px;
        font-size: 12px;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row row-cols-1 row-cols-md-2" id="printarea">
                            <div class="col-md-12">
                                <table class="table table-hover small">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Date</th>
                                            <th>Qty</th>
                                            <th>+ Qty</th>
                                            <th>- Qty</th>
                                            <th>Total Qty</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($rowgrn = $resultgrn->fetch_assoc()) {
                                            if ($rowgrn['source'] == 'Purchase Order') {
                                                $sumpo += $rowgrn['quantity'];
                                                $poqty = $rowgrn['quantity'];
                                            } elseif ($rowgrn['source'] == 'Stock') {
                                                $sumstock =  $availstock + $rowgrn['quantity'];
                                                $availstock = $sumstock - $sumpo + $sumrtn;
                                            } elseif ($rowgrn['source'] == 'GRN') {
                                                $sumgrn += $rowgrn['quantity'];
                                            } elseif ($rowgrn['source'] == 'Return') {
                                                $sumrtn += $rowgrn['quantity'];
                                            }

                                        ?>
                                            <tr>
                                                <td><?php echo $rowgrn['source']; ?></td>
                                                <td><?php echo $rowgrn['date']; ?></td>
                                                <td><?php if ($rowgrn['source'] == 'Stock') {
                                                        echo $rowgrn['quantity'] . "<span class='text-success'><b> (+" . $sumstockqty . ")</b></span>";
                                                    } elseif ($rowgrn['source'] == 'GRN') {
                                                        echo $rowgrn['quantity'] . "<span class='text-warning'><b> (+" . $sumgrnqty . ")</b></span>";
                                                    } elseif ($rowgrn['source'] == 'Return') {
                                                        echo $rowgrn['quantity'] . "<span class='text-danger'><b> (+" . $sumrtnqty . ")</b></span>";
                                                    } else {
                                                        echo '';
                                                    } ?></td>
                                                <td><?php if ($rowgrn['source'] == 'Stock') {
                                                        echo $sumstockqty + $rowgrn['quantity'] . "<span class='text-danger'><b> (+" . $sumrtnqty . ")</b></span>";
                                                    } elseif ($rowgrn['source'] == 'GRN') {
                                                        echo $sumgrnqty + $rowgrn['quantity'];
                                                    } elseif ($rowgrn['source'] == 'Return') {
                                                        echo $sumrtnqty + $rowgrn['quantity'];
                                                    } else {
                                                        echo '';
                                                    } ?></td>
                                                <td><?php if ($rowgrn['source'] == 'Purchase Order') {
                                                        echo "<span class='text-primary'>" . $poqty . "</span>";
                                                    } elseif ($rowgrn['source'] == 'Stock') {
                                                        echo "<span class='text-primary'>-" . $sumpo . "</span>";
                                                        $sumpo = '';
                                                    } ?></td>


                                                <td><?php
                                                    if ($rowgrn['source'] == 'Stock') {
                                                        echo "<span class='text-dark'><b>" . $availstock . "</b></span>";
                                                        $sumpo = 0;
                                                        $sumrtn = 0;
                                                    } elseif ($rowgrn['source'] == 'Purchase Order') {
                                                        echo $sumpo;
                                                    } elseif ($rowgrn['source'] == 'GRN') {
                                                        echo $sumgrn;
                                                    } elseif ($rowgrn['source'] == 'Return') {
                                                        echo $sumrtn;
                                                    }
                                                    $sumstockqty = $availstock;
                                                    $sumgrnqty = $sumgrn;
                                                    $sumrtnqty = $sumrtn;
                                                    ?></td>

                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <div class="container ml-1">
                                 <div class="d-flex"><div class="circle1"></div><div class="txt">GRN Qty</div></div>
                                </div>
                                <div class="container ml-1">
                                 <div class="d-flex"><div class="circle2"></div><div class="txt">Stock Qty</div></div>
                                </div>
                                <div class="container ml-1">
                                 <div class="d-flex"><div class="circle3"></div><div class="txt">PO Qty</div></div>
                                </div>
                                <div class="container ml-1">
                                 <div class="d-flex"><div class="circle4"></div><div class="txt">Return Qty</div></div>
                                </div>
                                <div class="container ml-1">
                                 <div class="d-flex"><div class="circle5"></div><div class="txt">Available Stock Qty</div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            dom: 'Blfrtip',
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
        });
        document.getElementById('btnprint').addEventListener("click", print);
    });

    function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
</script>