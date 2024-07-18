<?php 
include "include/header.php";  

// $sql="SELECT * FROM `tbl_user` WHERE `status` IN (1,2) AND `idtbl_user`!=1";
// $result =$conn-> query($sql); 

$sqlusertypeuser="SELECT * FROM `tbl_supplier`";
$resultusertypeuser=$conn->query($sqlusertypeuser);

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
                            <span>Material Management</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-4">
                                <form action="process/materialprocess.php" method="post" autocomplete="off">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Material Name*</label>
                                        <input type="text" class="form-control form-control-sm" name="materialname"
                                            id="materialname" required>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Barcode*</label>
                                        <input type="text" class="form-control form-control-sm" name="barcode" id="barcode"
                                            required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-1">
                                            <label class="small font-weight-bold text-dark">Unit Price*</label>
                                            <input type="text" class="form-control form-control-sm" name="unitprice"
                                                id="unitprice" required>
                                        </div>
                                        <div class="col-md-6 form-group mb-1">
                                            <label class="small font-weight-bold text-dark">Sale Price*</label>
                                            <input type="text" class="form-control form-control-sm" name="saleprice"
                                                id="saleprice" required>
                                        </div>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Reorder Level*</label>
                                        <input type="text" class="form-control form-control-sm" name="reorderlevel"
                                            id="reorderlevel" required>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-1">
                                            <label class="small font-weight-bold text-dark">Retail price*</label>
                                            <input type="text" class="form-control form-control-sm" name="retailprice"
                                                id="retailprice" required>
                                        </div>
                                        <div class="col-md-6 form-group mb-1">
                                            <label class="small font-weight-bold text-dark">Retail discount*</label>
                                            <input type="text" class="form-control form-control-sm" name="retaildiscount"
                                                id="retaildiscount" required>
                                        </div>
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
                                                <th>Material</th>
                                                <th>Barcode</th>
                                                <th class="text-right">Unit Price</th>
                                                <th class="text-right">Sale Price</th>
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
    $(document).ready(function () {
        var addcheck
        var editcheck
        var statuscheck
        var deletecheck


        $('#dataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: "scripts/materiallist.php",
                type: "POST", // you can use GET
            },
            "order": [
                [0, "desc"]
            ],
            "columns": [{
                    "data": "idtbl_material"
                },
                {
                    "data": "materialname"
                },
                {
                    "data": "materialbarcode"
                },
                {
                    "data": "unitprice",
                    "className": 'text-right',
                },
                {
                    "data": "saleprice",
                    "className": 'text-right',
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function (data, type, full) {
                        var button = '';
                        button += '<button class="btn btn-outline-primary btn-sm btnEdit mr-1 ';
                        if (editcheck == 0) {
                            button += 'd-none';
                        }
                        button += '" id="' + full['idtbl_material'] +
                            '"><i class="fas fa-pen"></i></button>';
                        if (full['status'] == 1) {
                            button += '<a href="process/statusmaterial.php?record=' + full[
                                    'idtbl_material'] +
                                '&type=2" onclick="return deactive_confirm()" target="_self" class="btn btn-outline-success btn-sm mr-1 ';
                            if (statuscheck == 0) {
                                button += 'd-none';
                            }
                            button += '"><i class="fas fa-check"></i></a>';
                        } else {
                            button += '<a href="process/statusmaterial.php?record=' + full[
                                    'idtbl_material'] +
                                '&type=1" onclick="return active_confirm()" target="_self" class="btn btn-outline-warning btn-sm mr-1 ';
                            if (statuscheck == 0) {
                                button += 'd-none';
                            }
                            button += '"><i class="fas fa-times"></i></a>';
                        }
                        button += '<a href="process/statusmaterial.php?record=' + full[
                                'idtbl_material'] +
                            '&type=3" onclick="return delete_confirm()" target="_self" class="btn btn-outline-danger btn-sm ';
                        if (deletecheck == 0) {
                            button += 'd-none';
                        }
                        button += '"><i class="far fa-trash-alt"></i></a>';

                        return button;
                    }
                }
            ],
            drawCallback: function (settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#dataTable tbody').on('click', '.btnEdit', function () {
            var r = confirm("Are you sure, You want to Edit this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: 'getprocess/getmaterialdetails.php',
                    success: function (result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#materialname').val(obj.materialname);
                        $('#barcode').val(obj.materialbarcode);
                        $('#unitprice').val(obj.unitprice);
                        $('#saleprice').val(obj.saleprice);
                        $('#reorderlevel').val(obj.reorderlevel);
                        $('#retailprice').val(obj.retail);
                        $('#retaildiscount').val(obj.retaildiscount);

                        $('#recordOption').val('2');
                        $("#divchange").addClass("d-none");
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                        $('#submitBtn').prop("disabled", false);
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

    function addCommas(nStr){
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

</script>
<?php include "include/footer.php"; ?>
