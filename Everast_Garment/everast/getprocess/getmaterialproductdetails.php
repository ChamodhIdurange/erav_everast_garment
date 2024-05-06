<?php
require_once('../connection/db.php');

$productid = $_POST['recordID'];

$sql = "SELECT `m`.`materialname`, `m`.`idtbl_material`, `pm`.`qty`, `pm`.`idtbl_product_materials` FROM `tbl_material` AS `m` JOIN `tbl_product_materials` AS `pm` ON (`m`.`idtbl_material` = `pm`.`tbl_material_idtbl_material`) WHERE `pm`.`status`=1 AND `pm`.`tbl_product_idtbl_product` = '$productid'";
$result = $conn->query($sql);

?>

<div class="row">
    <table class="table table-bordered table-striped table-sm nowrap" id="tablelistdata">
        <thead>
            <tr>
                <th>#</th>
                <th>Material</th>
                <th>Required Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if($result->num_rows > 0) {while ($row = $result-> fetch_assoc()) {?>

            <tr>
                <td><?php echo $row['idtbl_material'] ?></td>
                <td><?php echo $row['materialname'] ?></td>
                <td><?php echo $row['qty'] ?></td>
                <td class="text-right">
                    <button class="btn btn-outline-danger btn-sm btnDeleteData" id="<?php echo $row['idtbl_product_materials'] ?>"><i
                    class="fa fa-trash"></i></button>
                </td>
            </tr>


            <?php }} ?> </tbody>
    </table>
</div>

<script>
    $('#tablelistdata tbody').on('click', '.btnDeleteData', function () {
        let productmaterialid = $(this).attr('id')
        $.ajax({
            type: "POST",
            data: {
                recordID: productmaterialid
            },
            url: 'process/deletematirielproductdata.php',
            success: function (result) {
                action(result);
            }
        });
    })
</script>