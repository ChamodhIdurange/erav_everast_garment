<?php
require_once('../connection/db.php');
session_start();
$to=$_POST['to']; 
$from=$_POST['from']; 
$userid = $_SESSION['userid'];



$query2 = "SELECT `e`.`name`, `o`.`name` as 'offer', `e`.`star_points`,`o`.`arranged_date`, `o`.`location` FROM `tbl_offer` as `o` JOIN `tbl_elec_offer` as `eo` ON (`eo`.`tbl_offer_idtbl_offer` = `o`.`idtbl_offer`) JOIN `tbl_electrician` as `e` ON (`e`.`idtbl_electrician` = `eo`.`tbl_electrician_idtbl_electrician`)  WHERE `o`.`arranged_date` >= '$from' and `o`.`arranged_date` <= '$to'";
$result2 = $conn->query($query2);
?>

<div class="col-12">
    <br>
    <div class="scrollbar pb-3" id="style-2">
        <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
            <thead>
                <tr>
                    <th>Electrician</th>
                    <th>Remaining points</th>
                    <th>Offer</th>
                    <th>Location</th>
                    <th>Arranged Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if($result2->num_rows > 0) {while ($row = $result2-> fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo $row['star_points'] ?></td>
                    <td><?php echo $row['offer'] ?></td>
                    <td><?php echo $row['location'] ?></td>
                    <td><?php echo $row['arranged_date'] ?></td>
                </tr>
                <?php }} ?>
            </tbody>
        </table>
    </div>
</div>