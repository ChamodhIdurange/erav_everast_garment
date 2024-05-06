<?php
require_once('../connection/db.php');
session_start();
$record=$_POST['recordID']; //inquiry ID
$points=$_POST['points']; //inquiry ID
$userid = $_SESSION['userid'];

$array = [];


$query1 = "SELECT `idtbl_electrician`, `name` FROM `tbl_electrician` WHERE `star_points` >= $points and `status` = '1'";
$result1 = $conn->query($query1);

$query2 = "SELECT `tbl_electrician_idtbl_electrician` FROM `tbl_elec_offer` WHERE `tbl_offer_idtbl_offer` = $record";
$result2 = $conn->query($query2);

while ($row = $result1-> fetch_assoc()) { 
    $c = 0;
    while ($row2 = $result2-> fetch_assoc()) { 
        if($row['idtbl_electrician'] == $row2['tbl_electrician_idtbl_electrician']){
            $c = 1;
        }
        // echo "<script>console.log('Debug Objects: " . "success". "' );</script>";
        
    }

    if($c == 0){
        $obj=new stdClass();
        $obj->elecid=$row['idtbl_electrician'];
        $obj->elecname=$row['name'];
        array_push($array,$obj);
    }

}
$length = count($array);

$query2 = "SELECT * FROM `tbl_offer`  WHERE `idtbl_offer` = $record";
$result2 = $conn->query($query2);

echo "<script>console.log('Debug Objects: " . $array[0]->elecid . "' );</script>";
?>

<?php 
    while($rowdetail=$result2->fetch_assoc()){?>
<div class="row">
    <div class="col-md-6">
        <h5>Offer : <?php echo $rowdetail["name"] ?></h5>
    </div>
    <div class="col-md-6">
        <h5>Location : <?php echo $rowdetail["location"] ?></h5>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h5>Arranged date : <?php echo $rowdetail["arranged_date"] ?></h5>
    </div>
    <div class="col-md-6">
        <h5>Star points : <?php echo $rowdetail["required_points"] ?></h5>
    </div>
</div>
<?php } ?>

<div class="row">
    <div class="col-md-12">
        <form id="quotationform" action="process/offerelectricianprocess.php" enctype="multipart/form-data"
            method="post" autocomplete="off">

            <input type="hidden" value="<?php echo $record ?>" id="offerid" name="offerid">
            <input type="hidden" value="<?php echo $points ?>" id="points" name="points">
            <table class="table table-striped table-bordered table-sm small">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Electrician names</th>
                        <th>Action</th>

                </thead>
                <tbody>
                    <?php 
                for($i = 0; $i <$length; $i++){?>
                    <tr>

                        <td><?php echo $array[$i]->elecid ?></td>
                        <td><?php echo $array[$i]->elecname?></td>
                        <td><input type="checkbox" class="check-input lg"
                                value="<?php echo $array[$i]->elecid  ?>" name="elecid[]" value="elecid">
                        </td>

                    </tr>
                    <?php 
  
                  } ?>

            </table>
            </tbody>
            <tfoot>
                <div class="form-group mt-2">
                    <button type="submit" id="submitBtn" class="btn btn-outline-primary btn-sm w-50 fa-pull-right"><i
                            class="far fa-save"></i>&nbsp;Add</button>
                </div>
            </tfoot>

        </form>
    </div>
</div>