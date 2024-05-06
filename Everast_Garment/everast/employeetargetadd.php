<?php 
include "include/header.php";  

$sqlemployee="SELECT `idtbl_employee`, `name` FROM `tbl_employee` WHERE `tbl_user_type_idtbl_user_type` IN ('8','9') AND `status`=1";
$resultemployee =$conn-> query($sqlemployee); 

$sqlproductcat="SELECT `idtbl_product_category`, `category` FROM `tbl_product_category` WHERE `status`=1";
$resultproductcat =$conn-> query($sqlproductcat); 


$sqlproduct="SELECT `idtbl_product`, `product_name` FROM `tbl_product` WHERE `status`=1";
$resultproduct =$conn-> query($sqlproduct); 

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
                            <div class="page-header-icon"><i data-feather="target"></i></div>
                            <span>Emplyee Target</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                                <form action="process/employeetargetaddprocess.php" method="post" id="targetform"
                                    autocomplete="off">
                                    <div class="row">
                                        <div class="col-md-3 form-group mb-1">
                                            <label class="small font-weight-bold text-dark">Employee*</label>
                                            <select class="form-control form-control-sm" name="employee" id="employee"
                                                required>
                                                <option value="">Select</option>
                                                <?php if($resultemployee->num_rows > 0) {while ($rowemployee = $resultemployee-> fetch_assoc()) { ?>
                                                <option value="<?php echo $rowemployee['idtbl_employee'] ?>">
                                                    <?php echo $rowemployee['name'] ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group mb-1">
                                            <label class="small font-weight-bold text-dark">Month*</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control dpd1a" placeholder=""
                                                    name="targetmonth" id="targetmonth" required>
                                                <div class="input-group-append">
                                                    <span class="btn btn-light border-gray-500"><i
                                                            class="far fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 form-group mb-1">
                                            <label class="small font-weight-bold text-dark">Product category*</label>
                                            <select class="form-control form-control-sm" name="productcat"
                                                id="productcat" required>
                                                <?php if($resultproductcat->num_rows > 0) {while ($rowproduct = $resultproductcat-> fetch_assoc()) { ?>
                                                <option value="<?php echo $rowproduct['idtbl_product_category'] ?>">
                                                    <?php echo $rowproduct['category'] ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Target Qty*</label>
                                        <input type="text" class="form-control form-control-sm" name="target" id="target" required>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Target Value*</label>
                                        <input type="text" class="form-control form-control-sm" name="targetvalue" id="targetvalue" required>
                                    </div> -->
                                    <div class="form-group mt-2">
                                        <button type="submit" id="submitBtn" class="d-none"
                                            <?php if($addcheck==0){echo 'disabled';} ?>><i
                                                class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                                    <input type="hidden" name="recordID" id="recordID" value="">
                                </form>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12">
                                <hr class="border-dark">
                                <div class="row">
                                    <div class="col-md-6" id="targetviewdetail"></div>
                                    <div class="col-md-6">
                                        <table class="table table-striped table-bordered table-sm"
                                            id="selecteddetailtable">
                                            <thead>
                                                <tr>
                                                    <th class="d-none">#</th>
                                                    <th>Product</th>
                                                    <th>Qty</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <div class="form-group mt-2">
                                            <button type="button" id="createBtn"
                                                class="btn btn-outline-primary btn-sm px-4 fa-pull-right"><i
                                                    class="far fa-save"></i>&nbsp;Create</button>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-dark">
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
        var addcheck = '<?php echo $addcheck; ?>';
        var editcheck = '<?php echo $editcheck; ?>';
        var statuscheck = '<?php echo $statuscheck; ?>';
        var deletecheck = '<?php echo $deletecheck; ?>';

        $('.dpd1a').datepicker({
            uiLibrary: 'bootstrap4',
            autoclose: 'true',
            todayHighlight: true,
            startDate: 'today',
            format: 'yyyy-mm',
            viewMode: "months",
            minViewMode: "months"
        });


        $('#productcat').change(function () {
            var categoryID = $(this).val();
            $('#targetviewdetail').html(
                '<div class="card border-0 shadow-none bg-transparent"><div class="card-body text-center"><img src="images/spinner.gif" alt="" srcset=""></div></div>'
            );

            $.ajax({
                type: "POST",
                data: {
                    categoryID: categoryID
                },
                url: 'getprocess/gettargetadddetails.php',
                success: function (result) { //alert(result);
                    $('#targetviewdetail').html(result);

                }
            });
        });
    });

    $('#createBtn').click(function () { //alert('IN');
        var tbody = $("#selecteddetailtable tbody");

        if (tbody.children().length > 0) {
            jsonObj = [];
            $("#selecteddetailtable tbody tr").each(function () {
                item = {}
                $(this).find('td').each(function (col_idx) {
                    item["col_" + (col_idx + 1)] = $(this).text();
                });
                jsonObj.push(item);
            });

            var employee = $('#employee').val();
            var targetmonth = $('#targetmonth').val();

            console.log(jsonObj)
            console.log(targetmonth)
            $.ajax({
                type: "POST",
                data: {
                    tableData: jsonObj,
                    targetmonth: targetmonth,
                    employee: employee,
                },
                url: 'process/employeetargetaddprocess.php',
                success: function (result) {
                    action(result);
                    $('#selecteddetailtable').empty()
                    $('#employee').val()
                    $('#targetmonth').val()
                    $('#productcat').val()
                    // location.reload();
                }
            });
        }
    });


    function action(data) { //alert(data);
        var obj = JSON.parse(data);
        $.notify({
            // options
            icon: obj.icon,
            title: obj.title,
            message: obj.message,
            url: obj.url,
            target: obj.target
        }, {
            // settings
            element: 'body',
            position: null,
            type: obj.type,
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "center"
            },
            offset: 100,
            spacing: 10,
            z_index: 1031,
            delay: 5000,
            timer: 1000,
            url_target: '_blank',
            mouse_over: null,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
            template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                '<span data-notify="icon"></span> ' +
                '<span data-notify="title">{1}</span> ' +
                '<span data-notify="message">{2}</span>' +
                '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                '</div>' +
                '<a href="{3}" target="{4}" data-notify="url"></a>' +
                '</div>'
        });
    }

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