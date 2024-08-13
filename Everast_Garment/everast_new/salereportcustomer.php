<?php 
include "include/header.php";  

$sqlcustomer="SELECT `idtbl_customer`, `name` FROM `tbl_customer` WHERE `status`=1 ORDER BY `name` ASC";
$resultcustomer =$conn-> query($sqlcustomer);

$sqlproduct="SELECT `idtbl_product`, `product_name` FROM `tbl_product` WHERE `status`=1 ORDER BY `product_name` ASC";
$resultproduct =$conn-> query($sqlproduct);

$sqlarea="SELECT `idtbl_area`, `area` FROM `tbl_area` WHERE `status`=1 ORDER BY `area` ASC";
$resultarea =$conn-> query($sqlarea);

$sqlrep="SELECT `idtbl_employee`, `name` FROM `tbl_employee` WHERE `status`=1 ORDER BY `name` ASC";
$resultrep =$conn-> query($sqlrep);

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
                            <span>Sale Report</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                                <form id="saleInformationForm">
                                    <div class="form-row">
                                        <div class="col-2">
                                            <label class="small font-weight-bold text-dark">Search Type*</label>
                                            <div class="input-group input-group-sm">
                                                <select class="form-control form-control-sm" name="searchType"
                                                    id="searchType">
                                                    <option value="0">Select Type</option>
                                                    <option value="1">All</option>
                                                    <option value="2">Rep Vise</option>
                                                    <option value="3">Product Vise</option>
                                                    <option value="4">Customer Vise</option>
                                                    <option value="5">Area Vise</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2 search-dependent" style="display: none" id="selectAll">
                                            <label class="small font-weight-bold text-dark">All*</label>
                                        </div>
                                        <div class="col-2 search-dependent" style="display: none" id="selectSaleRepDiv">
                                            <label class="small font-weight-bold text-dark">Rep*</label>
                                            <select class="form-control form-control-sm" style="width: 100%;"
                                                name="selectSaleRep" id="selectSaleRep">
                                                <option value="0">All</option>
                                                <?php while ($rowresultrep = $resultrep->fetch_assoc()) { ?>
                                                <option value="<?php echo $rowresultrep['idtbl_employee']; ?>">
                                                    <?php echo $rowresultrep['name']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-2 search-dependent" style="display: none" id="selectProductDiv">
                                            <label class="small font-weight-bold text-dark">Product*</label>
                                            <select class="form-control form-control-sm" style="width: 100%;"
                                                name="selectProduct" id="selectProduct">
                                                <option value="0">All</option>
                                                <?php while ($rowproductlist = $resultproduct->fetch_assoc()) { ?>
                                                <option value="<?php echo $rowproductlist['idtbl_product']; ?>">
                                                    <?php echo $rowproductlist['product_name']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-2 search-dependent" style="display: none"
                                            id="selectCustomerDiv">
                                            <label class="small font-weight-bold text-dark">Customer*</label>
                                            <select class="form-control form-control-sm" style="width: 100%;"
                                                name="selectCustomer" id="selectCustomer">
                                                <option value="0">All</option>
                                                <?php while ($rowcustomerlist = $resultcustomer->fetch_assoc()) { ?>
                                                <option value="<?php echo $rowcustomerlist['idtbl_customer']; ?>">
                                                    <?php echo $rowcustomerlist['name']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-2 search-dependent" style="display: none" id="selectAreaDiv">
                                            <label class="small font-weight-bold text-dark">Area*</label>
                                            <select class="form-control form-control-sm" style="width: 100%;"
                                                name="selectArea" id="selectArea">
                                                <option value="0">All</option>
                                                <?php while ($rowarealist = $resultarea->fetch_assoc()) { ?>
                                                <option value="<?php echo $rowarealist['idtbl_area']; ?>">
                                                    <?php echo $rowarealist['area']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-2 search-dependent" style="display: none" id="selectDateFrom">
                                            <label class="small font-weight-bold text-dark">From*</label>
                                            <input type="date" class="form-control form-control-sm" name="fromdate"
                                                id="fromdate" required>
                                        </div>
                                        <div class="col-2 search-dependent" style="display: none" id="selectDateTo">
                                            <label class="small font-weight-bold text-dark">To*</label>
                                            <input type="date" class="form-control form-control-sm" name="todate"
                                                id="todate" required>
                                        </div>
                                        <div class="col-1 search-dependent" style="display: none;" id="hidesumbit">
                                            &nbsp;<br>
                                            <button type="submit"
                                                class="btn btn-outline-danger btn-sm ml-auto w-25 mt-2 px-5 btnPdf"
                                                id="submitBtn">
                                                <i class="fas fa-file-pdf"></i>&nbsp;View
                                            </button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="recordID" id="recordID" value="">
                                </form>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <hr class="border-dark">
                            <div id="targetviewdetail">
                                <table id="salesReportTable" class="display">
                                </table>
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
    $('#searchType').change(function() {
        var searchType = $(this).val();
        resetFields();
        if (searchType == 1) {
            $('#selectDateFrom, #selectDateTo, #hidesumbit').show();
        } else if (searchType == 2) {
            $('#selectSaleRepDiv, #selectDateFrom, #selectDateTo, #hidesumbit').show();
        } else if (searchType == 3) {
            $('#selectProductDiv, #selectDateFrom, #selectDateTo, #hidesumbit').show();
        } else if (searchType == 4) {
            $('#selectCustomerDiv, #selectDateFrom, #selectDateTo, #hidesumbit').show();
        } else if (searchType == 5) {
            $('#selectAreaDiv, #selectDateFrom, #selectDateTo, #hidesumbit').show();
        }
    });

    $('#saleInformationForm').submit(function(event) {
        event.preventDefault();

        var validfrom = $('#fromdate').val();
        var validto = $('#todate').val();
        var customer = getElementValue('#selectCustomer');
        var product = getElementValue('#selectProduct');
        var rep = getElementValue('#selectSaleRep');
        var area = getElementValue('#selectArea');

        $.ajax({
            type: "POST",
            data: {
                validfrom: validfrom,
                validto: validto,
                customer: customer,
                rep: rep,
                product: product,
                area: area,
            },
            url: 'getprocess/getcustomersalereportaccoperiod.php',
            success: function(result) {
                $('#targetviewdetail').html(result);
                
                if ($.fn.DataTable.isDataTable('#reportTable')) {
                    $('#reportTable').DataTable().destroy(); 
                }

                $('#reportTable').DataTable({
                    "dom": "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                    "buttons": [
                        { 
                            extend: 'csv', 
                            className: 'btn btn-success btn-sm', 
                            title: 'Everest Sale Report Information', 
                            text: '<i class="fas fa-file-csv mr-2"></i> CSV'
                        },
                        { 
                            extend: 'pdf', 
                            className: 'btn btn-danger btn-sm', 
                            title: 'Everest Sale Report Information', 
                            text: '<i class="fas fa-file-pdf mr-2"></i> PDF'
                        },
                        { 
                            extend: 'print', 
                            title: 'Everest Sale Report Information',
                            className: 'btn btn-primary btn-sm', 
                            text: '<i class="fas fa-print mr-2"></i> Print'
                        }
                    ]
                });
            }
        });
    });

    function getElementValue(id) {
        var element = $(id);
        if (element.length === 0) {
            //console.error('Element with ID', id, 'not found.');
            return null;
        }
        return element.val();
    }

    function resetFields() {
        $('.search-dependent').hide();
    }

    function resetForm() {
        $('#saleInformationForm')[0].reset();
        resetFields();
        $('#searchType').val(0);
    }
});


</script>