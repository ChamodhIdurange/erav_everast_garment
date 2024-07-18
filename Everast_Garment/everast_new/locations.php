<?php 
include "include/header.php";  



$sqllocation="SELECT * FROM `tbl_locations` WHERE `status` in ('1','2')";
$resultlocations=$conn->query($sqllocation);

$sqlBank="SELECT * FROM `tbl_bank` WHERE `status` in ('1')";
$resultBank=$conn->query($sqlBank);

$sqldistrict="SELECT * FROM `tbl_district`";
$resultdistrict =$conn-> query($sqldistrict); 

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
                            <div class="page-header-icon"><i data-feather="map-pin"></i></div>
                            <span>Location Management</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-4">
                                <form action="process/locationprocess.php" method="post" autocomplete="off">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Province*</label>
                                        <input type="text" class="form-control form-control-sm" name="province"
                                            id="province" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="small font-weight-bold text-dark">District*</label>
                                        <select name="district" id="district" class="form-control form-control-sm"
                                            required>
                                            <option value="">Select</option>
                                            <?php if($resultdistrict->num_rows > 0) {while ($rowdistrict = $resultdistrict-> fetch_assoc()) { ?>
                                            <option value="<?php echo $rowdistrict['idtbl_district'] ?>">
                                                <?php echo $rowdistrict['name'] ?></option>
                                            <?php }} ?>
                                        </select>
                                    </div>

                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">City*</label>
                                        <input type="text" class="form-control form-control-sm" name="city" id="city"
                                            required>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Location name*</label>
                                        <input type="text" class="form-control form-control-sm" name="locationname"
                                            id="locationname" required>
                                    </div>

                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Address*</label>
                                        <textarea class="form-control form-control-sm " name="address"
                                            id="address"></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group mb-1">
                                            <label class="small font-weight-bold text-dark">Contact Number 01*</label>
                                            <input type="number" class="form-control form-control-sm" name="contact1"
                                                id="contact1" required>
                                        </div>
                                        <div class="col-md-6 form-group mb-1">
                                            <label class="small font-weight-bold text-dark">Contact Number 02*</label>
                                            <input type="number" class="form-control form-control-sm" name="contact2"
                                                id="contact2" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-1">
                                            <label class="small font-weight-bold text-dark">Head person*</label>
                                            <input type="text" class="form-control form-control-sm" name="headperson"
                                                id="headperson" required>
                                        </div>
                                        <div class="col-md-6 form-group mb-1">
                                            <label class="small font-weight-bold text-dark">Contact person*</label>
                                            <input type="text" class="form-control form-control-sm" name="contactperson"
                                                id="contactperson" required>
                                        </div>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Email address*</label>
                                        <input type="text" class="form-control form-control-sm" name="email" id="email"
                                            required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-1">
                                            <label class="small font-weight-bold text-dark">Bank name*</label>
                                            <select class="form-control form-control-sm" name="bank" id="bank"
                                                required>
                                                <option value="">Select</option>
                                                <?php if($resultBank->num_rows > 0) {while ($rowcategory = $resultBank-> fetch_assoc()) { ?>
                                                <option value="<?php echo $rowcategory['idtbl_bank'] ?>">
                                                    <?php echo $rowcategory['bankname'] ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group mb-1">
                                            <label class="small font-weight-bold text-dark">Account owner*</label>
                                            <input type="text" class="form-control form-control-sm" name="accountowner"
                                                id="accountowner" required>
                                        </div>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Account number*</label>
                                        <input type="text" class="form-control form-control-sm" name="accountnumber" id="accountnumber"
                                            required>
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
                                                <th>Location name</th>
                                                <th>City</th>
                                                <th>Address</th>
                                                <th>Contact</th>
                                                <th>Email</th>
                                                <th>Head person</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($resultlocations->num_rows > 0) {while ($row = $resultlocations-> fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $row['idtbl_locations'] ?></td>
                                                <td><?php echo $row['locationname'] ?></td>
                                                <td><?php echo $row['city'] ?></td>
                                                <td><?php echo $row['address'] ?></td>
                                                <td><?php echo $row['contact1'] ?></td>
                                                <td><?php echo $row['email'] ?></td>
                                                <td><?php echo $row['headperson'] ?></td>
                                                <td class="text-right">

                                                    <button class="btn btn-outline-primary btn-sm btnEdit"
                                                        id="<?php echo $row['idtbl_locations'] ?>"><i
                                                            data-feather="edit-2"></i></button>
                                                    <?php if($row['status']==1){ ?>
                                                    <a href="process/statuslocation.php?record=<?php echo $row['idtbl_locations'] ?>&type=2"
                                                        onclick="return confirm('Are you sure you want to deactive this?');"
                                                        target="_self" class="btn btn-outline-success btn-sm"><i
                                                            data-feather="check"></i></a>
                                                    <?php }else{ ?>
                                                    <a href="process/statuslocation.php?record=<?php echo $row['idtbl_locations'] ?>&type=1"
                                                        onclick="return confirm('Are you sure you want to active this?');"
                                                        target="_self" class="btn btn-outline-warning btn-sm"><i
                                                            data-feather="x-square"></i></a>
                                                    <?php } ?>
                                                    <a href="process/statuslocation.php?record=<?php echo $row['idtbl_locations'] ?>&type=3"
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
                    url: 'getprocess/getlocations.php',
                    success: function (result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#province').val(obj.province);
                        $('#district').val(obj.district);
                        $('#city').val(obj.city);
                        $('#locationname').val(obj.location);
                        $('#address').val(obj.address);
                        $('#contact1').val(obj.contact1);
                        $('#contact2').val(obj.contact2);
                        $('#contactperson').val(obj.contactperson);
                        $('#email').val(obj.email);
                        $('#headperson').val(obj.headperson);
                        $('#bank').val(obj.bank);
                        $('#accountowner').val(obj.accountowner);
                        $('#accountnumber').val(obj.accountnumber);


                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');

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