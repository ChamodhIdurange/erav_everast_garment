<?php
require_once('../connection/db.php');

$record=$_POST['recordID'];

$sql="SELECT  `d`.`idtbl_starpoints_details`, `p`.`product_name`, `p`.`idtbl_product`, `d`.`quantity`, `d`.`starpoints` FROM `tbl_electrician_box` as `eb` JOIN `tbl_starpoints_details` AS `d` ON (`d`.`tbl_electrician_box_idtbl_electrician_box` = `eb`.`idtbl_electrician_box`) JOIN `tbl_product` as `p` ON (`p`.`idtbl_product` = `d`.`tbl_product_idtbl_product`) WHERE `d`.`tbl_electrician_box_idtbl_electrician_box` = '$record'";
$result=$conn->query($sql);
?>

<div class="row">
    <table id="returndetailstable" class="table table-striped table-bordered table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Total points</th>

            </tr>
        </thead>
        <tbody>
            <?php while($row=$result->fetch_assoc()){ ?>
            <tr>
                <td><?php echo $row['idtbl_starpoints_details'] ?></td>
                <td><?php echo $row['product_name'] ?></td>
                <td class="text-center"><?php echo $row['quantity'] ?></td>
                <td class="text-center"><?php echo $row['starpoints'] ?></td>

            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


