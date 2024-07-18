<?php
session_start();
require_once('../connection/db.php');


$item = $_POST['item'];



$sqlgrn = "SELECT `grn`.`idtbl_grndetail`, `grn`.`qty` FROM `tbl_grndetail` AS `grn` WHERE `grn`.`tbl_product_idtbl_product` = '$item'";
$resultgrn = $conn->query($sqlgrn);
$sqlstk = "SELECT `stk`.`idtbl_stock`, `stk`.`qty` FROM `tbl_stock` AS `stk` WHERE `stk`.`tbl_product_idtbl_product` = '$item'";
$resultstk = $conn->query($sqlstk);
$sqlpo = "SELECT `po`.`idtbl_porder_detail`, `po`.`qty`, `porder`.`idtbl_porder` FROM `tbl_porder_detail` AS `po` LEFT JOIN `tbl_porder` AS `porder` ON (`porder`.`idtbl_porder` = `po`.`tbl_porder_idtbl_porder`) WHERE `po`.`tbl_product_idtbl_product` = '$item'";
$resultpo = $conn->query($sqlpo);
$sqlreturn = "SELECT `rt`.`idtbl_return_details`, `rt`.`qty`, `rtn`.`idtbl_return` FROM `tbl_return_details` AS `rt` LEFT JOIN `tbl_return` AS `rtn` ON (`rtn`.`idtbl_return` = `rt`.`tbl_return_idtbl_return`) WHERE `rt`.`tbl_product_idtbl_product` = '$item'";
$resultreturn = $conn->query($sqlreturn);
$newqty = 0;
$sumgrn = 0;
$newqtystk = 0;
$sumgrnstk = 0;
$newqtypo = 0;
$sumgrnpo = 0;
$newqtyreturn = 0;
$sumgrnreturn = 0;
$getstk = 0;
$getpo = 0;
$getreturn = 0;
?>

<style>

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
                                        <th></th>
                                        <th>Opening Qty</th>
                                        <th>Total Qty</th>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if ($resultgrn->num_rows > 0) {
                                            $row_count = $resultgrn->num_rows;
                                            $first_row = true;
                                            $current_row = 0;
                                            while ($rowgrn = $resultgrn->fetch_assoc()) {
                                                $current_row++;
                                                $newqty = $sumgrn + $rowgrn['qty'];
                                                if ($first_row) { ?>
                                                    <tr>
                                                        <td rowspan="<?php echo $row_count ?>"> <span class="text-warning">GRN</span></td>
                                                    <?php $first_row = false;
                                                } else { ?>
                                                    <tr>
                                                    <?php } ?>
                                                    <td> <?php echo $rowgrn['qty'] ?> </td>
                                                    <td>
                                                        <?php

                                                        if ($current_row == $row_count) {
                                                            echo "<span class='text-warning'><b>" . $newqty . "</b></span>";
                                                        } else {
                                                            echo $newqty;
                                                        }
                                                        ?>
                                                    </td>
                                                    </tr>
                                                    <?php
                                                    $sumgrn = $newqty;
                                                }
                                            }

                                            if ($resultstk->num_rows > 0) {
                                                $row_count = $resultstk->num_rows;
                                                $first_row = true;
                                                $current_row = 0;
                                                while ($rowstk = $resultstk->fetch_assoc()) {
                                                    $current_row++;
                                                    $newqtystk = $sumgrnstk + $rowstk['qty'];
                                                    if ($first_row) { ?>

                                                        <tr>
                                                            <td rowspan="<?php echo $row_count ?>"><span class="text-success">Stock</span></td> <?php
                                                                                                                $first_row = false;
                                                                                                            } else { ?>
                                                        <tr>
                                                        <?php } ?>
                                                        <td> <?php echo $rowstk['qty'] ?> </td>
                                                        <td>
                                                            <?php

                                                            if ($current_row == $row_count) {
                                                                echo "<span class='text-success'><b>" . $newqtystk . "</b></span>";
                                                                $getstk = $newqtystk;
                                                            } else {
                                                                echo $newqtystk;
                                                            }
                                                            ?>
                                                        </td>
                                                        </tr>
                                                        <?php
                                                        $sumgrnstk = $newqtystk;
                                                    }
                                                }
                                                if ($resultpo->num_rows > 0) {
                                                    $row_count = $resultpo->num_rows;
                                                    $first_row = true;
                                                    $current_row = 0;
                                                    while ($rowpo = $resultpo->fetch_assoc()) {
                                                        $current_row++;
                                                        $newqtypo = $sumgrnpo + $rowpo['qty'];
                                                        if ($first_row) { ?>

                                                            <tr>
                                                                <td rowspan="<?php echo $row_count ?>"><span class="text-primary">PO</span></td> <?php
                                                                                                                $first_row = false;
                                                                                                            } else { ?>
                                                            <tr>
                                                            <?php } ?>
                                                            <td><span style="font-size: 11px;">(PO0<?php echo $rowpo['idtbl_porder'] ?>)</span> <?php echo $rowpo['qty'] ?> </td>
                                                            <td>
                                                                <?php

                                                                if ($current_row == $row_count) {
                                                                    echo "<span class='text-primary'><b>" . $newqtypo . "</b></span>";
                                                                    $getpo = $newqtypo;
                                                                } else {
                                                                    echo $newqtypo;
                                                                }
                                                                ?></td>
                                                            </tr>
                                                    <?php
                                                        $sumgrnpo = $newqtypo;
                                                    }
                                                }
                                                if ($resultreturn->num_rows > 0) {
                                                    $row_count = $resultreturn->num_rows;
                                                    $first_row = true;
                                                    $current_row = 0;
                                                    while ($rowreturn = $resultreturn->fetch_assoc()) {
                                                        $current_row++;
                                                        $newqtyreturn = $sumgrnreturn + $rowreturn['qty'];
                                                        if ($first_row) { ?>

                                                            <tr>
                                                                <td rowspan="<?php echo $row_count ?>"><span class="text-danger">Return</span></td> <?php
                                                                                                                $first_row = false;
                                                                                                            } else { ?>
                                                            <tr>
                                                            <?php } ?>
                                                            <td><span style="font-size: 11px;">(RTN0<?php echo $rowreturn['idtbl_return'] ?>)</span><?php echo $rowreturn['qty'] ?> </td>
                                                            <td>
                                                                <?php

                                                                if ($current_row == $row_count) {
                                                                    echo "<span class='text-danger'><b>" . $newqtyreturn . "</b></span>";
                                                                    $getreturn = $newqtyreturn;
                                                                } else {
                                                                    echo $newqtyreturn;
                                                                }
                                                                ?></td>
                                                            </tr>
                                                    <?php
                                                        $sumgrnreturn = $newqtyreturn;
                                                    }
                                                }
                                                $totalpore =  $getpo + $getreturn;
                                                $available = $getstk - $totalpore;
                                                    ?>
                                                    <tr>
                                                        <td colspan="2">Available <span class='text-success'>Stock</span> With <span class="text-danger">Return</span></td>
                                                        <td> <p style="font-size: large;"><b><?php echo $available?></b></td>
                                                </tr>
                                                    
                                    </tbody>
                                </table>



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
        })
        document.getElementById('btnprint').addEventListener("click", print);
    });

    function addCommas(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
</script>