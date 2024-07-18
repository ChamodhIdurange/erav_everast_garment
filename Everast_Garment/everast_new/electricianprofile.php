<?php 
include "include/header.php";  

// $sql="SELECT * FROM `tbl_user` WHERE `status` IN (1,2) AND `idtbl_user`!=1";
// $result =$conn-> query($sql); 

$record=$_GET['record'];
$type=$_GET['type'];
$persontype = "Electrician";

$sqlelectrician="SELECT * FROM `tbl_contact_details` WHERE `person_id` = '$record' AND `status` in (1,2) and `type` = 'Electrician'";
$resultelectrician=$conn->query($sqlelectrician);



$sqlelec="SELECT `star_points`, `name`, `contact` FROM `tbl_electrician` WHERE `idtbl_electrician` = '$record'";
$resultelec =$conn-> query($sqlelec); 
$resultpoints = $resultelec-> fetch_assoc();



$sqlgainedpoints="SELECT `eb`.`idtbl_electrician_box`, `eb`.`recieveddate`, `eb`.`totalstarpoints`, `e`.`idtbl_electrician`, `e`.`name` FROM `tbl_electrician_box` as `eb` JOIN `tbl_electrician` as `e` ON (`e`.`idtbl_electrician` = `eb`.`tbl_electrician_idtbl_electrician`) WHERE `eb`.`tbl_electrician_idtbl_electrician` = '$record'";
$resultgainedpoints =$conn-> query($sqlgainedpoints); 


$sqloffers="SELECT * FROM `tbl_offer` as `o` JOIN `tbl_elec_offer` as `e` ON (`e`.`tbl_offer_idtbl_offer` = `o`.`idtbl_offer`) WHERE `status` in ('1','2') AND `e`.`tbl_electrician_idtbl_electrician` = '$record' GROUP BY `o`.`idtbl_offer`";
$resultoffers =$conn-> query($sqloffers); 


$sqlBank="SELECT * FROM `tbl_bank` WHERE `status` in ('1')";
$resultBank=$conn->query($sqlBank);

$sqlElecBank="SELECT `b`.`bankname`, `b`.`code`,`a`.`branchname`,`a`.`accountnumber`, `a`.`status`, `a`.`idtbl_bank_account_details`, `a`.`account_name` FROM `tbl_bank` as `b` JOIN `tbl_bank_account_details` AS `a` ON (`a`.`tbl_bank_idtbl_bank` = `b`.`idtbl_bank`) WHERE `a`.`status` in ('1') AND `a`.`person_id` = '$record' and `a`.`type` = 'Electrician'";
$resultElecBank=$conn->query($sqlElecBank);

$sql="SELECT * FROM `tbl_offer` WHERE `status` in ('1','2')";
$result=$conn->query($sql);


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
                            <span><?php echo $resultpoints['name'] ?>'s Profile</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="container rounded bg-white mt-5 mb-5">
                                <div class="row">
                                    <div class="col-md-3 border-right">
                                        <div class="d-flex flex-column align-items-center text-center p-3 py-2"><img
                                                class="rounded-circle mt-5" width="150px"
                                                src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span
                                                class="font-weight-bold"><?php echo $resultpoints['name']; ?></span><span
                                                class="text-black-50"><?php  echo $resultpoints['contact'] ?></span><span>Star
                                                points - <?php echo $resultpoints['star_points']; ?> </span></div>
                                    </div>
                                    <div class="col-md-9 border-right">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                                    role="tab" aria-controls="home" aria-selected="true">Contact
                                                    Info</a>
                                            </li>

                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="supplier-tab" data-toggle="tab" href="#supplier"
                                                    role="tab" aria-controls="supplier" aria-selected="false">Bank
                                                    Info</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="gainedpoints-tab" data-toggle="tab"
                                                    href="#gainedpoints" role="tab" aria-controls="gainedpoints"
                                                    aria-selected="false">Gained Star Points</a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="offers-tab" data-toggle="tab" href="#offers"
                                                    role="tab" aria-controls="offers" aria-selected="false">Recived
                                                    Offers</a>
                                            </li>


                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                                aria-labelledby="home-tab">
                                                <div class="inputrow">
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-12 text-right">
                                                            <button class="btn btn-outline-primary btn-sm "
                                                                data-toggle="modal" data-target="#modelcontactdetails">
                                                                <i class="far fa-save"></i>&nbsp;Add contact details
                                                            </button>

                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="scrollbar pb-3" id="style-2">

                                                                <table
                                                                    class="table table-bordered table-striped table-sm nowrap"
                                                                    id="dataTable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Contact owner</th>
                                                                            <th>Relation</th>
                                                                            <th>Number</th>
                                                                            <th>Email address</th>
                                                                            <th>Actions</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php if($resultelectrician->num_rows > 0) {while ($row = $resultelectrician-> fetch_assoc()) { ?>
                                                                        <tr>
                                                                            <td><?php echo $row['idtbl_contact_details'] ?>
                                                                            </td>
                                                                            <td><?php echo $row['contact_owner'] ?></td>
                                                                            <td><?php echo $row['relation'] ?></td>
                                                                            <td><?php echo $row['number'] ?></td>
                                                                            <td><?php echo $row['email'] ?></td>

                                                                            <td class="text-right">
                                                                                <button
                                                                                    class="btn btn-outline-primary btn-sm btnEditContact mr-1 "
                                                                                    id="<?php echo $row['idtbl_contact_details'] ?>"><i
                                                                                        class=" fas fa-edit"></i></button>

                                                                                <a href="process/statuscontactdetails.php?record=<?php echo $row['idtbl_contact_details'] ?>&eledID=<?php echo $record ?>&type=<?php echo $persontype ?>"
                                                                                    onclick="return confirm('Are you sure you want to remove this?');"
                                                                                    target="_self"
                                                                                    class="btn btn-outline-danger btn-sm"><i
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
                                            <div class="tab-pane fade" id="supplier" role="tabpanel"
                                                aria-labelledby="supplier-tab">
                                                <div class="inputrow">

                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-12 text-right">
                                                            <button class="btn btn-outline-primary btn-sm "
                                                                data-toggle="modal" data-target="#modelbankdetails">
                                                                <i class="far fa-save"></i>&nbsp;Add bank details
                                                            </button>

                                                        </div>

                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="scrollbar pb-3" id="style-2">
                                                                <table
                                                                    class="table table-bordered table-striped table-sm nowrap"
                                                                    id="dataTablebank">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Bank Name</th>
                                                                            <th>Bank Code</th>
                                                                            <th>Branch</th>
                                                                            <th>Account name</th>
                                                                            <th>Account number</th>
                                                                            <th>Actions</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php if($resultElecBank->num_rows > 0) {while ($row = $resultElecBank-> fetch_assoc()) { ?>
                                                                        <tr>
                                                                            <td><?php echo $row['idtbl_bank_account_details'] ?>
                                                                            </td>
                                                                            <td><?php echo $row['bankname'] ?></td>
                                                                            <td><?php echo $row['code'] ?></td>
                                                                            <td><?php echo $row['branchname'] ?></td>
                                                                            <td><?php echo $row['account_name'] ?></td>
                                                                            <td><?php echo $row['accountnumber'] ?></td>

                                                                            <td class="text-right">
                                                                                <button
                                                                                    class="btn btn-outline-primary btn-sm btnEditBank mr-1 "
                                                                                    id="<?php echo $row['idtbl_bank_account_details'] ?>"><i
                                                                                        class=" fas fa-edit"></i></button>

                                                                                <a href="process/statusbankdetails.php?record=<?php echo $row['idtbl_bank_account_details'] ?>&eledID=<?php echo $record ?>&type=<?php echo $persontype ?>"
                                                                                    onclick="return confirm('Are you sure you want to remove this?');"
                                                                                    target="_self"
                                                                                    class="btn btn-outline-danger btn-sm"><i
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
                                            <div class="tab-pane fade" id="gainedpoints" role="tabpanel"
                                                aria-labelledby="gainedpoints-tab">
                                                <div class="inputrow">

                                                    <br>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="scrollbar pb-3" id="style-2">
                                                                <table
                                                                    class="table table-bordered table-striped table-sm nowrap"
                                                                    id="dataTable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Received Date</th>
                                                                            <th>Star Points</th>
                                                                            <th class="text-right">Actions</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php if($resultgainedpoints->num_rows > 0) {while ($row = $resultgainedpoints-> fetch_assoc()) { ?>
                                                                        <tr>
                                                                            <td><?php echo $row['idtbl_electrician_box'] ?>
                                                                            </td>
                                                                            <td><?php echo $row['recieveddate'] ?></td>
                                                                            <td><?php echo $row['totalstarpoints'] ?>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <button
                                                                                    class="btn btn-outline-primary btn-sm btnShow"
                                                                                    id="<?php echo $row['idtbl_electrician_box'] ?>"
                                                                                    data-toggle="tooltip"
                                                                                    data-original-title="View details"><i
                                                                                        data-feather="eye"></i></button>

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
                                            <div class="tab-pane fade" id="offers" role="tabpanel"
                                                aria-labelledby="offers-tab">
                                                <div class="inputrow">

                                                    <br>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="scrollbar pb-3" id="style-2">
                                                                <table
                                                                    class="table table-bordered table-striped table-sm nowrap"
                                                                    id="dataTable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Offer</th>
                                                                            <th>Arranged Date</th>
                                                                            <th>Location</th>
                                                                            <th>Required points</th>
                                                                            <th>Remarks</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php if($resultoffers->num_rows > 0) {while ($row = $resultoffers-> fetch_assoc()) { ?>
                                                                        <tr>
                                                                            <td><?php echo $row['idtbl_offer'] ?></td>
                                                                            <td><?php echo $row['name'] ?></td>
                                                                            <td><?php echo $row['arranged_date'] ?></td>
                                                                            <td><?php echo $row['location'] ?></td>
                                                                            <td><?php echo $row['required_points'] ?>
                                                                            </td>
                                                                            <td><?php echo $row['remarks'] ?></td>


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
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
    </div>
</div>
</main>

<!-- Modal point details -->
<div class="modal fade" id="modalpointdetails" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
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
                        <div id="viewdetail"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bank Details Modal -->
<div class="modal fade" id="modelbankdetails" tabindex="-1" aria-labelledby="modelbankdetails" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelbankdetails">Bank Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="contactform" action="process/personalbankinfoprocess.php"
                            enctype="multipart/form-data" method="post" autocomplete="off">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Bank Name*</label>
                                        <select class="form-control form-control-sm" name="bank" id="bank" required>
                                            <option value="">Select</option>
                                            <?php if($resultBank->num_rows > 0) {while ($rowcategory = $resultBank-> fetch_assoc()) { ?>
                                            <option value="<?php echo $rowcategory['idtbl_bank'] ?>">
                                                <?php echo $rowcategory['bankname'] ?></option>
                                            <?php }} ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Branch Name*</label>
                                        <input type="text" class="form-control form-control-sm" name="branchname"
                                            id="branchname" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Account name*</label>
                                        <input type="text" class="form-control form-control-sm" name="accountname"
                                            id="accountname" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Account number*</label>
                                        <input type="text" class="form-control form-control-sm" name="accountnumber"
                                            id="accountnumber" required>
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mt-2">
                                        <button type="submit" id="submitBtnbank"
                                            class="btn btn-outline-primary btn-sm w-50 fa-pull-right"><i
                                                class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" value="Electrician" id="usertypebank" name="usertypebank">
                            <input type="hidden" value=<?php echo $record ?> id="recordbank" name="recordbank">
                            <input type="hidden" value="0" id="recordIDBank" name="recordIDBank">
                            <!-- <input type="hidden" value=<?php echo $type ?> id="typebank" name="typebank"> -->
                            <input type="hidden" name="recordOptionBank" id="recordOptionBank" value="1">
                            <!--    <input type="text" name="quotationid" id="quotationid" value=""> -->
                        </form>
                    </div>


                </div>
            </div>

        </div>
    </div>
</div>

<!-- Contact Details Modal -->
<div class="modal fade" id="modelcontactdetails" tabindex="-1" aria-labelledby="modelcontactdetails" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelcontactdetails">Contact Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="contactform" action="process/contactinfoprocess.php" enctype="multipart/form-data"
                            method="post" autocomplete="off">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Contact person*</label>
                                        <input type="text" class="form-control form-control-sm" name="ownername"
                                            id="ownername" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Contact Number*</label>
                                        <input type="text" class="form-control form-control-sm" name="number"
                                            id="number" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Relation*</label>
                                        <input type="text" class="form-control form-control-sm" name="relation"
                                            id="relation" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Email*</label>
                                        <input type="text" class="form-control form-control-sm" name="email" id="email"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mt-2">
                                        <button type="submit" id="submitBtnContact"
                                            class="btn btn-outline-primary btn-sm w-50 fa-pull-right"><i
                                                class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" value="Electrician" id="usertype" name="usertype">
                            <input type="hidden" value="0" id="recordID" name="recordID">
                            <input type="hidden" value=<?php echo $record ?> id="record" name="record">
                            <!-- <input type="hidden" value=<?php echo $type ?> id="type" name="type"> -->
                            <input type="hidden" name="recordOptionContact" id="recordOptionContact" value="1">

                            <!--    <input type="text" name="quotationid" id="quotationid" value=""> -->
                        </form>
                    </div>


                </div>
            </div>

        </div>
    </div>
</div>
<?php include "include/footerbar.php"; ?>
</div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
    $('#dataTable').DataTable();
    $('#dataTablebank').DataTable();
    $(document).ready(function () {
        var addcheck
        var editcheck
        var statuscheck
        var deletecheck

        $('#dataTable tbody').on('click', '.btnEditContact', function () {
            var r = confirm("Are you sure, You want to Edit this ? ");
            var type = "Electrician"
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id,
                        type: type
                    },
                    url: 'getprocess/getelectritioncontact.php',
                    success: function (result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#ownername').val(obj.name);
                        $('#relation').val(obj.relation);
                        // $('#usertype').val(obj.type);
                        $('#number').val(obj.number);
                        $('#email').val(obj.email);




                        $('#submitBtnContact').html(
                            '<i class="far fa-save"></i>&nbsp;Update');
                        $('#recordOptionContact').val('2');
                        $('#modelcontactdetails').modal('show');
                    }
                });
            }
        });

        $('#dataTablebank tbody').on('click', '.btnEditBank', function () {
            var r = confirm("Are you sure, You want to Edit this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                var type = "Electrician"
                $.ajax({
                    type: "POST",
                    data: {

                        recordID: id,
                        type: type
                    },
                    url: 'getprocess/getelectritionbank.php',
                    success: function (result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordIDBank').val(obj.id);
                        $('#bank').val(obj.bankname);
                        $('#branchname').val(obj.branchname);
                        // $('#usertype').val(obj.type);
                        $('#accountnumber').val(obj.accountnumber);
                        $('#accountname').val(obj.accountname);





                        $('#submitBtnbank').html('<i class="far fa-save"></i>&nbsp;Update');
                        $('#recordOptionBank').val('2');
                        $('#modelbankdetails').modal('show');
                    }
                });
            }
        });



    });

    $('#dataTable tbody').on('click', '.btnShow', function () {
        var id = $(this).attr('id');
        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: 'getprocess/Getelectricianboxdetails.php',
            success: function (result) {
                // alert(result)
                $('#viewmodaltitle').html('Return No ' + id)
                $('#viewdetail').html(result);
                $('#modalpointdetails').modal('show');
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