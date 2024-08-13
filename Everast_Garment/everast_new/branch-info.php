<?php
include "include/header.php";

$sqlbank="SELECT `idtbl_bank`, `bankname` FROM `tbl_bank` WHERE `status`=1 AND `idtbl_bank`>0";
$resultbank =$conn-> query($sqlbank); 

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
                    <div class="page-header-content d-flex align-items-center justify-content-between py-3">
                        <div class="d-inline">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="dollar-sign"></i></div>
                                <span>Branch Information</span>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-md-3">
                                <form class="" action="process/bankbranchinfoprocess.php" method="post" autocomplete="off">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Bank</label>
                                        <select class="form-control form-control-sm" id="bank" name="bank" >
                                            <option value="">Select</option>
                                            <?php while($rowbank = $resultbank->fetch_assoc()){ ?>
                                            <option value="<?php echo $rowbank['idtbl_bank'] ?>"><?php echo $rowbank['bankname'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Code</label>
                                        <input class="form-control form-control-sm" type="text" name="code" id="code" minlength="4" maxlength="4" required>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Branch Name</label>
                                        <input class="form-control form-control-sm" type="text" id="branch" name="branch">
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Telephone</label>
                                        <input class="form-control form-control-sm" type="text" id="telephone" name="telephone" >
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Address</label>
                                        <textarea class="form-control form-control-sm" type="text" id="address" name="address"></textarea>
                                    </div>
                                    <div class="form-group mt-3">
                                        <button type="submit" id="submitBtn" class="btn btn-outline-primary btn-sm px-4 fa-pull-right" <?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                                    <input type="hidden" name="recordID" id="recordID" value="">
                                </form>
                            </div>
                            <div class="col-md-9">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Bank</th>
                                                <th>Code</th>
                                                <th>Branch Name</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
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
    $(document).ready(function() {

    var addcheck='<?php echo $addcheck; ?>';
    var editcheck='<?php echo $editcheck; ?>';
    var statuscheck='<?php echo $statuscheck; ?>';
    var deletecheck='<?php echo $deletecheck; ?>';

    $('#dataTable').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: "scripts/bankbranchlist.php",
            type: "POST",
        },
        "order": [[0, "desc"]],
        "columns": [
            { 
                "data": "idtbl_bank_branch" 
            },
            {
                "data": "bankname"
            },
            {
                "data": "code"},
            {
                "data": "branchname"
            },
            {
                "data": "phone"
            },
            {
                "data": "address"
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';

                    button += '<button class="btn btn-outline-primary btn-sm mr-1 btnEdit ' + (editcheck == 0 ? 'd-none' : '') + '" id="' + full['idtbl_bank_branch'] + '"><i data-feather="edit-2"></i></button>';

                    if (full['status'] == 1) {
                        button += '<a href="process/statusbankbranchinfo.php?record=' + full['idtbl_bank_branch'] + '&type=2" onclick="return confirm(\'Are you sure you want to deactivate this?\');" target="_self" class="btn btn-outline-success mr-1 btn-sm ' + (statuscheck == 0 ? 'd-none' : '') + '"><i data-feather="check"></i></a>';
                    } else {
                        button += '<a href="process/statusbankbranchinfo.php?record=' + full['idtbl_bank_branch'] + '&type=1" onclick="return confirm(\'Are you sure you want to activate this?\');" target="_self" class="btn btn-outline-warning mr-1 btn-sm ' + (statuscheck == 0 ? 'd-none' : '') + '"><i data-feather="x-square"></i></a>';
                    }
                    button += '<a href="process/statusbankbranchinfo.php?record=' + full['idtbl_bank_branch'] + '&type=3" onclick="return confirm(\'Are you sure you want to remove this?\');" target="_self" class="btn btn-outline-danger btn-sm ' + (deletecheck == 0 ? 'd-none' : '') + '"><i data-feather="trash-2"></i></a>';

                    return button;
                }
            }
        ]
    }).on('draw.dt', function() {
        feather.replace();
    });

    $('#dataTable tbody').on('click', '.btnEdit', function() {
        var r = confirm("Are you sure, You want to Edit this ? ");
        if (r == true) {
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: 'getprocess/getbranchinfo.php',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);

                    $('#recordID').val(obj.id);
                    $('#bank').val(obj.bank);
                    $('#code').val(obj.code);
                    $('#branch').val(obj.branchname);
                    $('#telephone').val(obj.phone);
                    $('#address').val(obj.address);
                    $('#recordOption').val('2');
                    $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');

                }
            });
        }
    });
});
</script>
<?php include "include/footer.php";?>
