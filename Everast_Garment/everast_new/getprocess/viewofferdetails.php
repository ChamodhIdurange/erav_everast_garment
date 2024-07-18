<?php
require_once('../connection/db.php');
session_start();
$record=$_POST['recordID']; //inquiry ID
$userid = $_SESSION['userid'];
$count = 0;
$query1 = "SELECT `e`.`idtbl_electrician`, `e`.`name` FROM `tbl_elec_offer` as `o` JOIN `tbl_electrician` as `e` on (`e`.`idtbl_electrician` = `o`.`tbl_electrician_idtbl_electrician`) WHERE `o`.`tbl_offer_idtbl_offer` = $record";
$result1 = $conn->query($query1);
?>

<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-bordered table-sm small">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Electrician name</th>

            </thead>
            <tbody>
                <?php $i=1; $tot = 0;
    while($rowdetail=$result1->fetch_assoc()){?>
                <tr>

                    <td><?php echo $rowdetail["idtbl_electrician"] ?></td>
                    <td><?php echo $rowdetail["name"] ?></td>
                </tr>
                <?php 
  
    } ?>
            </tbody>

        </table>

    </div>
</div>
