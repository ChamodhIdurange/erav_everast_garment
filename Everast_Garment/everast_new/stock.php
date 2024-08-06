<?php 
include "include/header.php";  
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
                            <div class="page-header-icon"><i data-feather="file"></i></div>
                            <span>Stock Report</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                                <form id="searchform">
                                    <div class="form-row">
                                        <div class="col-3">
                                            <label class="small font-weight-bold text-dark">Date*</label>
                                            <div class="input-group input-group-sm mb-3">
                                                <input type="text" class="form-control dpd1a rounded-0" id="fromdate"
                                                    name="fromdate" value="<?php echo date('Y-m-d') ?>" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text rounded-0"
                                                        id="inputGroup-sizing-sm"><i data-feather="calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">&nbsp;</label><br>
                                            <button class="btn btn-outline-dark btn-sm rounded-0 px-4" type="button"
                                                id="formSearchBtn"><i class="fas fa-search"></i>&nbsp;Search</button>
                                        </div>
                                    </div>
                                    <input type="submit" class="d-none" id="hidesubmit">
                                </form>
                            </div>
                            <div class="col-12">
                                <hr class="border-dark">
                                <div id="targetviewdetail" style="display: none;">
                                    <table id="dataTable" class="display table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Color</th>
                                                <th>Category</th>
                                                <th>Group Category</th>
                                                <th>Size</th>
                                                <th>Retail price</th>
                                                <th class="text-center">Available Stock</th>
                                                <th>Total price</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <!-- <button class="btn btn-outline-danger btn-sm fa-pull-right" id="btnprint" style="display: none;">
                                    <i class="fas fa-print"></i>&nbsp;Print Report
                                </button> -->
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
        $('.dpd1a').datepicker('remove');
        $('.dpd1a').datepicker({
            uiLibrary: 'bootstrap4',
            autoclose: 'true',
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });

        $('#formSearchBtn').click(function () {
            if (!$("#searchform")[0].checkValidity()) {
                $("#hidesubmit").click();
            } else {
                var fromdate = $('#fromdate').val();

                $('#targetviewdetail').html(
                    '<div class="card border-0 shadow-none bg-transparent"><div class="card-body text-center"><img src="images/spinner.gif" alt="" srcset=""></div></div>'
                ).show();

                $.ajax({
                    type: "POST",
                    data: { fromdate: fromdate },
                    url: 'getprocess/getselectedstock.php',
                    success: function (result) {
                        $('#targetviewdetail').html(result);
                        if ($.fn.DataTable.isDataTable('#dataTable')) {
                            $('#dataTable').DataTable().destroy();
                        }
                        $('#dataTable').DataTable({
                            dom: 'Blfrtip',
                            "lengthMenu": [
                                [10, 25, 50, -1],
                                [10, 25, 50, "All"]
                            ],
                            "buttons": [
                                { 
                                    extend: 'csv', 
                                    className: 'btn btn-success btn-sm', 
                                    title: 'Stock Report', 
                                    text: '<i class="fas fa-file-csv mr-2"></i> CSV'
                                },
                                { 
                                    extend: 'pdf', 
                                    className: 'btn btn-danger btn-sm', 
                                    title: 'Stock Report', 
                                    text: '<i class="fas fa-file-pdf mr-2"></i> PDF'
                                },
                                { 
                                    extend: 'print', 
                                    className: 'btn btn-primary btn-sm', 
                                    title: 'Stock Report',
                                    text: '<i class="fas fa-print mr-2"></i> Print'
                                }
                            ],
                            "paging": true,
                            "searching": true,
                            "ordering": true,
                        });
                        $('#btnprint').show();
                    }
                });
            }
        });

        $('#btnprint').click(function () {
            printJS({
                printable: 'printarea',
                type: 'html',
                targetStyles: ['*']
            });
        });
    });
</script>
<?php include "include/footer.php"; ?>
