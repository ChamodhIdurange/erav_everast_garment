<?php
require_once('../connection/db.php');
session_start();
$record=$_POST['recordID'];
$userid = $_SESSION['userid'];

$query1 = "SELECT `fd`.`idtbl_free_issue_details`, `fd`.`qty`, `p`.`product_name` FROM `tbl_free_issue_details` as `fd` join `tbl_free_issue` as `fe` ON (`fe`.`idtbl_free_issue` = `fd`.`tbl_free_issue_idtbl_free_issue`) JOIN `tbl_product` as `p` ON (`p`.`idtbl_product` = `fd`.`tbl_product_idtbl_product`) WHERE `fd`.`tbl_free_issue_idtbl_free_issue` = '$record'";
$result1 = $conn->query($query1);
?>

<div class="row">
    <div class="col-12">
        <!-- <table class="w-100 tableprint">
            <tbody>
                <tr>
                    <td>&nbsp;</td>

                    <td colspan="4" class="text-center small align-middle">
                        <h2 class="font-weight-light m-0">Free Issue details</h2>
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table> -->
    </div>
</div>
<h3><?php echo 'INQ00'.$record; ?></h3>

<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-bordered table-sm small">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Quantity</th>

                </tr>
            </thead>
            <tbody>
                <?php $i=1; $tot = 0;
    while($rowdetail=$result1->fetch_assoc()){ ?>
                <tr>
                    <td><?php echo $rowdetail["idtbl_free_issue_details"] ?></td>
                    <td><?php echo $rowdetail["product_name"] ?></td>
                    <td><?php echo $rowdetail["qty"] ?></td>

                </tr>
                <?php } ?>

            </tbody>

        </table>

    </div>
</div>