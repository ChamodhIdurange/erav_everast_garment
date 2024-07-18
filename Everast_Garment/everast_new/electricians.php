<?php 
include "include/header.php";  

// $sql="SELECT * FROM `tbl_user` WHERE `status` IN (1,2) AND `idtbl_user`!=1";
// $result =$conn-> query($sql); 

$sqlusertypeuser="SELECT * FROM `tbl_electrician`";
$resultusertypeuser=$conn->query($sqlusertypeuser);

$sqlarea="SELECT `idtbl_area`, `area` FROM `tbl_area` WHERE `status`=1";
$resultarea =$conn-> query($sqlarea); 

$sqlcustomer="SELECT `idtbl_customer`, `name` FROM `tbl_customer` WHERE `status`=1";
$resultcustomer =$conn-> query($sqlcustomer); 

$sqlelec="SELECT `e`.`idtbl_electrician`, `e`.`name`, `contact`, `c`.`name` as 'customer', `a`.`area` as 'area', `e`.`status` FROM `tbl_electrician` as `e` JOIN `tbl_customer` as `c` ON (`c`.`idtbl_customer` = `e`.`tbl_customer_idtbl_customer`) JOIN `tbl_area` as `a` ON (`a`.`idtbl_area` = `e`.`tbl_area_idtbl_area`) WHERE `e`.`status`in ('1','2')";
$resultelec =$conn-> query($sqlelec); 

include "include/topnavbar.php"; 
?>


<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            <span>Eletrician Management</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-4">
                                <form action="process/electricianprocess.php" method="post" autocomplete="off">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Electrician Name*</label>
                                        <input type="text" class="form-control form-control-sm" name="elecname"
                                            id="elecname" required>
                                    </div>

                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Main Contact*</label>
                                        <input type="text" class="form-control form-control-sm" name="contactone"
                                            id="contactone" required>
                                    </div>

                                    <label class="small font-weight-bold text-dark">Area*</label>
                                    <select name="area" id="area" class="form-control form-control-sm" required>
                                        <option value="">Select</option>
                                        <?php if($resultarea->num_rows > 0) {while ($rowarea = $resultarea-> fetch_assoc()) { ?>
                                        <option value="<?php echo $rowarea['idtbl_area'] ?>">
                                            <?php echo $rowarea['area'] ?></option>
                                        <?php }} ?>
                                    </select>

                                    <label class="small font-weight-bold text-dark">Customer*</label>
                                    <select name="customer" id="customer" class="form-control form-control-sm" required>
                                        <option value="">Select</option>
                                        <?php if($resultcustomer->num_rows > 0) {while ($rowarea = $resultcustomer-> fetch_assoc()) { ?>
                                        <option value="<?php echo $rowarea['idtbl_customer'] ?>">
                                            <?php echo $rowarea['name'] ?></option>
                                        <?php }} ?>
                                    </select>

                                    <div class="row">
                                        <div class="col-md-6 form-group mb-1">
                                            <label class="small font-weight-bold text-dark">Reg No*</label>
                                            <input type="text" class="form-control form-control-sm" name="regno"
                                                id="regno" required>
                                        </div>
                                        <div class="col-md-6 form-group mb-1">
                                            <label class="small font-weight-bold text-dark">ID number*</label>
                                            <input type="text" class="form-control form-control-sm" name="idnumber"
                                                id="idnumber" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6  form-group mb-1">
                                            <label class="small font-weight-bold text-dark">Whatsapp No*</label>
                                            <input type="text" class="form-control form-control-sm" name="whatsappno"
                                                id="whatsappno" required>
                                        </div>

                                        <div class="col-md-6 form-group mb-1">
                                            <label class="small font-weight-bold text-dark">DOB*</label>
                                            <input type="date" class="form-control form-control-sm" name="dob" id="dob"
                                                required>
                                        </div>
                                    </div>


                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Address*</label>
                                        <input type="text" class="form-control form-control-sm" name="address"
                                            id="address" required>
                                    </div>
                                    <div class="form-group mt-2">
                                        <button type="submit" id="submitBtn"
                                            class="btn btn-outline-primary btn-sm w-50 fa-pull-right"><i
                                                class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                    <input type="hidden" name="recordOption" id="recordOption" value="1">

                                    <input type="hidden" name="recordID" id="recordID" value="">
                                </form>
                            </div>
                            <div class="col-8">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Customer</th>
                                                <th>Area</th>
                                                <th>Contact</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($resultelec->num_rows > 0) {while ($row = $resultelec-> fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $row['idtbl_electrician'] ?></td>
                                                <td><?php echo $row['name'] ?></td>
                                                <td><?php echo $row['customer'] ?></td>
                                                <td><?php echo $row['area'] ?></td>
                                                <td><?php echo $row['contact'] ?></td>
                                                <td class="text-right">
                                                    <a href="electricianprofile.php?record=<?php echo $row['idtbl_electrician'] ?>&type=1"
                                                        target="_self" class="btn btn-outline-primary btn-sm"><i
                                                            data-feather="eye"></i></a>
                                                    <button class="btn btn-outline-primary btn-sm btnEdit"
                                                        id="<?php echo $row['idtbl_electrician'] ?>"><i
                                                            data-feather="edit-2"></i></button>
                                                    <?php if($row['status']==1){ ?>
                                                    <a href="process/statuselectrition.php?record=<?php echo $row['idtbl_electrician'] ?>&type=2"
                                                        onclick="return confirm('Are you sure you want to deactive this?');"
                                                        target="_self" class="btn btn-outline-success btn-sm"><i
                                                            data-feather="check"></i></a>
                                                    <?php }else{ ?>
                                                    <a href="process/statuselectrition.php?record=<?php echo $row['idtbl_electrician'] ?>&type=1"
                                                        onclick="return confirm('Are you sure you want to active this?');"
                                                        target="_self" class="btn btn-outline-warning btn-sm"><i
                                                            data-feather="x-square"></i></a>
                                                    <?php } ?>
                                                    <a href="process/statuselectrition.php?record=<?php echo $row['idtbl_electrician'] ?>&type=3"
                                                        onclick="return confirm('Are you sure you want to remove this?');"
                                                        target="_self" class="btn btn-outline-danger btn-sm"><i
                                                            data-feather="trash-2"></i></a>
                                                </td>
                                            </tr>
                                            <?php }} ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>


<?php include "include/footerscripts.php"; ?>
<script>
    $('#dataTable').DataTable();
    $(document).ready(function () {
        var addcheck
        var editcheck
        var statuscheck
        var deletecheck

        $('#dataTable tbody').on('click', '.btnEdit', function () {
            var r = confirm("Are you sure, You want to Edit this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: 'getprocess/getelectrition.php',
                    success: function (result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#area').val(obj.area);
                        $('#customer').val(obj.customer);
                        $('#contactone').val(obj.contact);
                        $('#elecname').val(obj.name);
                        $('#regno').val(obj.regno);
                        $('#idnumber').val(obj.idnumber);
                        $('#whatsappno').val(obj.whatsappno);
                        $('#dob').val(obj.dob);
                        $('#address').val(obj.address);


                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');

                        $('#productlistimages').removeAttr('required');
                    }
                });
            }
        });

    });


    function deactive_confirm() {
        return confirm("Are you sure you want to deactive this?");
    }

    function active_confirm() {
        return confirm("Are you sure you want to active this?");
    }

    function delete_confirm() {
        return confirm("Are you sure you want to remove this?");
    }
</script>
<?php include "include/footer.php"; ?>