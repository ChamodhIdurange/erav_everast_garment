<?php 
include "include/header.php";  

 

$sql="SELECT * FROM `tbl_offer` WHERE `status` in ('1','2')";
$result=$conn->query($sql);

$sqlelectrician="SELECT `idtbl_electrician`, `name` FROM `tbl_electrician` WHERE `status` in (1,2)";
$resultelectrician =$conn-> query($sqlelectrician); 

; 

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
                            <div class="page-header-icon"><i data-feather="briefcase"></i></div>
                            <span>Assign Offers</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-outline-primary btn-sm " id="addbtn" data-toggle="modal"
                                    data-target="#modelform">
                                    <i class="fa fa-plus"></i>&nbsp;Add Offer
                                </button>

                            </div>

                        </div>
                        <div class="row">

                            <div class="col-12">
                                <br>
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Offer name</th>
                                                <th>Arranged date</th>
                                                <th>Location</th>
                                                <th>Required points</th>
                                                <th>Remarks</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($result->num_rows > 0) {while ($row = $result-> fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $row['idtbl_offer'] ?></td>
                                                <td><?php echo $row['name'] ?></td>
                                                <td><?php echo $row['arranged_date'] ?></td>
                                                <td><?php echo $row['location'] ?></td>
                                                <td><?php echo $row['required_points'] ?></td>
                                                <td><?php echo $row['remarks'] ?></td>
                                                <td class="text-center">
                                                    <button class="btn btn-outline-dark btn-sm btnView"
                                                        id="<?php echo $row['idtbl_offer'] ?>" data-toggle="tooltip"
                                                        data-original-title="View details"><i
                                                            data-feather="eye"></i></button>

                                                    <button class="btn btn-outline-primary btn-sm btnadd"
                                                        id="<?php echo $row['idtbl_offer'] ?>" name = "<?php echo $row['required_points'] ?>" data-toggle="tooltip"
                                                        data-original-title="Assign electricians"><i
                                                            data-feather="save"></i></button>

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

<!-- Form model -->
<div class="modal fade" id="modelform" tabindex="-1" aria-labelledby="modelform" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelcustomized">Offer Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="quotationform" action="process/offerprocess.php" enctype="multipart/form-data"
                            method="post" autocomplete="off">

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Offer Name*</label>
                                        <input type="text" class="form-control form-control-sm" name="name" id="name"
                                            required>
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Arranged Date*</label>
                                        <input type="date" class="form-control form-control-sm" name="arangeddate"
                                            id="arangeddate" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Venue*</label>
                                        <input type="text" class="form-control form-control-sm" name="location"
                                            id="location">
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Required points*</label>
                                        <input type="number" class="form-control form-control-sm" name="points"
                                            id="points" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Remarks*</label>
                                        <textarea class="form-control form-control-sm " name="remarks"
                                            id="remarks"></textarea>
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mt-2">
                                        <button type="submit" id="submitBtn"
                                            class="btn btn-outline-primary btn-sm w-50 fa-pull-right"><i
                                                class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="d-none" value="submit" id="quotationhiddensubmit">
                            <input type="hidden" class="form-control form-control-sm" value="<?php echo $record?>"
                                name="recordid" id="recordid" required>
                        </form>
                    </div>




                </div>
            </div>
        </div>

    </div>
</div>

<!-- Model -->
<div class="modal fade" id="modalofferdetails" tabindex="-1" role="dialog" aria-labelledby="modelshow"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalviewtitle">Selected Electricians</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modalbody"></div>
            </div>
        </div>
    </div>
</div>

<!-- Add electrician modal -->
<div class="modal fade" id="modalelectrician" tabindex="-1" role="dialog" aria-labelledby="modelshow"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalviewtitle">Select Electricians</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="electricianbody"></div>
            </div>
        </div>
    </div>
</div>
</div>

<?php include "include/footerscripts.php"; ?>
<script>
    $(document).ready(function () {
        $('#electrician').select2();
        $("#points").keyup(calculate);
        $('#dataTable').DataTable();

    });


    $('#dataTable tbody').on('click', '.btnView', function () {

        var id = $(this).attr('id');
        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: 'getprocess/viewofferdetails.php',
            success: function (result) { //alert(result);

                $('#modalbody').html(result);
                $('#modalofferdetails').modal('show');
            }
        });

    });

    $('#dataTable tbody').on('click', '.btnadd', function () {
        var id = $(this).attr('id');
        var points = $(this).attr('name');

        $.ajax({
            type: "POST",
            data: {
                recordID: id,
                points: points,
            },
            url: 'getprocess/selectelectricians.php',
            success: function (result) { //alert(result);

                $('#electricianbody').html(result);
                $('#modalelectrician').modal('show');
            }
        });

    });


    $("#addbtn").click(function () {
        $('#electrician').attr("disabled", false)
    });

    function calculate() {
        var points = $('#points').val();

        $.ajax({
            type: "POST",
            data: {
                points: points
            },
            url: 'getprocess/getelectritionlist.php',
            success: function(result) { //alert(result);
                var objfirst = JSON.parse(result);
                var html = '';
                html += '<option value="">Select</option>';
                $.each(objfirst, function(i, item) {
                    //alert(objfirst[i].id);
                    html += '<option value="' + objfirst[i].elecid + '">';
                    html += objfirst[i].elecname;
                    html += '</option>';
                });

                $('#electrician').empty().append(html);

            }
        });


    }
</script>
<?php include "include/footer.php"; ?>