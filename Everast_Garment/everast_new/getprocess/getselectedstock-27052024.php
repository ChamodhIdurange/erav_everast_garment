<?php 
session_start();
require_once('../connection/db.php');


$fromdate = $_POST['fromdate'];
$today =  date("Y-m-d");

// if($fromdate == $today){
//     $sqlstock="SELECT `p`.`retail`, `sp`.`category` as `subcat`, `gp`.`category` as `groupcat`,`pc`.`category` as `maincat`, `p`.`product_name`, `s`.`qty`, `m`.`name` FROM `tbl_stock` as `s` LEFT JOIN `tbl_product` as `p` ON (`p`.`idtbl_product`=`s`.`tbl_product_idtbl_product`) LEFT JOIN `tbl_sizes` AS `m` ON (`m`.`idtbl_sizes` = `p`.`tbl_sizes_idtbl_sizes`) LEFT JOIN `tbl_product_category` AS `pc` ON (`p`.`tbl_product_category_idtbl_product_category` = `pc`.`idtbl_product_category`) LEFT JOIN `tbl_sub_product_category` AS `sp` ON (`p`.`tbl_sub_product_category_idtbl_sub_product_category` = `sp`.`idtbl_sub_product_category`) LEFT JOIN `tbl_group_category` AS `gp` ON (`p`.`tbl_group_category_idtbl_group_category` = `gp`.`idtbl_group_category`) WHERE `s`.`status`=1 AND `p`.`status`=1 GROUP BY `s`.`tbl_product_idtbl_product` ORDER BY `m`.`sequence`, `m`.`tbl_size_categories_idtbl_size_categories` ASC";
// }else{
//     $sqlstock="SELECT `p`.`retail`, `sp`.`category` as `subcat`, `gp`.`category` as `groupcat`,`pc`.`category` as `maincat`, `p`.`product_name`, `s`.`qty`, `m`.`name` FROM `tbl_grn_stock` as `s` LEFT JOIN `tbl_product` as `p` ON (`p`.`idtbl_product`=`s`.`tbl_product_idtbl_product`) LEFT JOIN `tbl_sizes` AS `m` ON (`m`.`idtbl_sizes` = `p`.`tbl_sizes_idtbl_sizes`) LEFT JOIN `tbl_product_category` AS `pc` ON (`p`.`tbl_product_category_idtbl_product_category` = `pc`.`idtbl_product_category`) LEFT JOIN `tbl_sub_product_category` AS `sp` ON (`p`.`tbl_sub_product_category_idtbl_sub_product_category` = `sp`.`idtbl_sub_product_category`) LEFT JOIN `tbl_group_category` AS `gp` ON (`p`.`tbl_group_category_idtbl_group_category` = `gp`.`idtbl_group_category`) WHERE `s`.`status`=1 AND `p`.`status`=1 AND `s`.`grndate` = '$fromdate' ORDER BY `m`.`sequence`, `m`.`tbl_size_categories_idtbl_size_categories` ASC";
// }
$sqlstock="SELECT `p`.`retail`, `sp`.`category` as `subcat`, `gp`.`category` as `groupcat`,`pc`.`category` as `maincat`, `p`.`product_name`, SUM(`s`.`qty`) AS `qty`, `m`.`name` FROM `tbl_stock` as `s` LEFT JOIN `tbl_product` as `p` ON (`p`.`idtbl_product`=`s`.`tbl_product_idtbl_product`) LEFT JOIN `tbl_sizes` AS `m` ON (`m`.`idtbl_sizes` = `p`.`tbl_sizes_idtbl_sizes`) LEFT JOIN `tbl_product_category` AS `pc` ON (`p`.`tbl_product_category_idtbl_product_category` = `pc`.`idtbl_product_category`) LEFT JOIN `tbl_sub_product_category` AS `sp` ON (`p`.`tbl_sub_product_category_idtbl_sub_product_category` = `sp`.`idtbl_sub_product_category`) LEFT JOIN `tbl_group_category` AS `gp` ON (`p`.`tbl_group_category_idtbl_group_category` = `gp`.`idtbl_group_category`) WHERE `s`.`status`=1 AND `p`.`status`=1 GROUP BY `s`.`tbl_product_idtbl_product` ORDER BY `m`.`sequence`, `m`.`tbl_size_categories_idtbl_size_categories` ASC";

$resultstock =$conn-> query($sqlstock); 
?>
<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row row-cols-1 row-cols-md-2" id="printarea">
                            <div class="col-md-12">
                                <h6 class="small title-style"><span>Main stock</span></h6>
                                <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Color</th>
                                            <th>Category</th>
                                            <th>Group Category</th>
                                            <th>Size</th>
                                            <th>Retail price</th>
                                            <th class="text-center">Available Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($resultstock->num_rows > 0) {while ($rowstock = $resultstock-> fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $rowstock['product_name'] ?></td>
                                            <td><?php echo $rowstock['subcat'] ?></td>
                                            <td><?php echo $rowstock['maincat'] ?></td>
                                            <td><?php echo $rowstock['groupcat'] ?></td>
                                            <td><?php echo $rowstock['name'] ?></td>
                                            <td class="text-right">Rs.<?php echo $rowstock['retail'] ?>.00</td>
                                            <td class="text-center"><?php echo $rowstock['qty'] ?></td>
                                        </tr>
                                        <?php }} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-outline-danger btn-sm fa-pull-right" id="btnprint"><i
                                        class="fas fa-print"></i>&nbsp;Print Report</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal return details -->
    <div class="modal fade" id="actionmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <h5 class="modal-title" id="viewmodaltitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <div id="viewdetail">
                                <form id='submitform'>
                                    <input type="hidden" id='hiddenvalue' name='hiddenvalue'>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="statusradio" id="aceptradio"
                                            value="1" checked>
                                        <label class="form-check-label">Accept</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="statusradio"
                                            id="postponedradio" value="2">
                                        <label class="form-check-label">Postpone</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="statusradio" id="rejectradio"
                                            value="3">
                                        <label class="form-check-label">Reject</label>
                                    </div>
                                    <div class='mt-2' id='postponeddiv'>
                                        <label for="">Postponed Date</label>
                                        <input type='date' class="form-control" id="postponeddate"
                                            placeholder="Enter reason" required>
                                    </div>
                                    <div class='mt-2'>
                                        <label for="validationTextarea">Reason</label>
                                        <textarea class="form-control" id="reasontext" placeholder="Enter reason"
                                            required></textarea>
                                    </div>
                                    <button type="submit" id="formsubmit"
                                        class="btn btn-outline-primary btn-sm px-4 fa-pull-right mt-3"><i
                                            class="far fa-save"></i>&nbsp;Submit</button>
                                    <input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
                                </form>
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
    $(document).ready(function () {
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
