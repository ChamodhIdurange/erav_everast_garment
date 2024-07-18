<?php
include "include/header.php";

$sqlreturncustomer = "SELECT `e`.`name` as `asm`, `u`.`idtbl_return`, `u`.`returndate`, `u`.`total`, `ua`.`name` FROM `tbl_return` as `u` LEFT JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`) JOIN `tbl_employee` AS `e` ON (`e`.`idtbl_employee` = `u`.`tbl_employee_idtbl_employee`) WHERE `u`.`acceptance_status` = '0'";
$resultreturncustomer = $conn->query($sqlreturncustomer);

$sqlreturncustomeraccepted = "SELECT 
    e.name AS asm, 
    u.idtbl_return,
    u.returntype, 
    u.returndate, 
    u.total, 
    ua.name, 
    SUM(ur.payAmount) AS payAmount 
FROM 
    tbl_return AS u 
LEFT JOIN 
    tbl_customer AS ua ON ua.idtbl_customer = u.tbl_customer_idtbl_customer 
LEFT JOIN 
    tbl_employee AS e ON e.idtbl_employee = u.tbl_employee_idtbl_employee 
LEFT JOIN 
    tbl_creditenote AS ur ON ur.returnid = u.idtbl_return 
WHERE 
     u.credit_note = '1' 
GROUP BY 
    u.idtbl_return, e.name, u.returndate, u.total, ua.name
";
$resultreturncustomeraccepted = $conn->query($sqlreturncustomeraccepted);
$sqlreultissuecredit = "SELECT 
    e.name AS asm, 
    u.idtbl_return,
    u.returntype,  
    u.returndate, 
    u.total, 
    ua.name, 
    ur.payAmount,
    ur.idtbl_creditenote,
    ur.ctndate
FROM 
    tbl_return AS u 
LEFT JOIN 
    tbl_customer AS ua ON ua.idtbl_customer = u.tbl_customer_idtbl_customer 
LEFT JOIN 
    tbl_employee AS e ON e.idtbl_employee = u.tbl_employee_idtbl_employee 
LEFT JOIN 
    tbl_creditenote AS ur ON ur.returnid = u.idtbl_return 
WHERE  
        u.credit_note = '1' 
    AND u.credit_note_issue = '1' 

";
$resultreultissuecredit = $conn->query($sqlreultissuecredit);

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
                            <div class="page-header-icon"><i data-feather="corner-down-left"></i></div>
                            <span>Credit Note</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">

                            <div class="col-12">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">New Credit Note</a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="issuecreditnote-tab" data-toggle="tab" href="#issuecridtnote" role="tab" aria-controls="issuecridtnote" aria-selected="false">Issue Credit Note</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="inputrow">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="scrollbar pb-3" id="style-2">
                                                        <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Return Type</th>
                                                                    <th>ASM</th>
                                                                    <th>Customer name</th>
                                                                    <th>Date</th>
                                                                    <th class="text-right">Return Total</th>
                                                                    <th class="text-right">Pay Total</th>
                                                                    <th class="text-right">Balance</th>
                                                                    <th>Actions</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if ($resultreturncustomeraccepted->num_rows > 0) {
                                                                    while ($row = $resultreturncustomeraccepted->fetch_assoc()) { ?>
                                                                        <tr>

                                                                            <td>RTN-<?php echo $row['idtbl_return'] ?></td>
                                                                            <td><?php if($row['returntype'] == 1){echo "Customer Return";}else{echo "Damage Return";}?></td>
                                                                            <td><?php echo $row['asm'] ?></td>
                                                                            <td><?php echo $row['name'] ?></td>
                                                                            <td><?php echo $row['returndate'] ?></td>
                                                                            <td class="text-right">Rs.<?php echo number_format($row['total'], 2); ?>
                                                                            <td class="text-right">Rs.<?php echo number_format($row['payAmount'], 2); ?>
                                                                            <td class="text-right">Rs.<?php echo number_format($row['total'] - $row['payAmount'], 2); ?>
                                                                            </td>
                                                                            <td> <button class="btn btn-outline-primary btn-sm rounded btnView" id="<?php echo $row['idtbl_return']; ?>"><i class="fas fa-eye"></i></button>
                                                                                <!-- <button class="btn btn-danger btn-sm rounded btnprint" id="<?php echo $row['idtbl_return']; ?>"><i class="fas fa-print"></i></button> -->
                                                                                <button class="btn btn-danger btn-sm rounded issuebtn" id="<?php echo $row['idtbl_return']; ?>"><i class="fas fa-receipt"></i></button>

                                                                            </td>
                                                                        </tr>
                                                                <?php }
                                                                } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="issuecridtnote" role="tabpanel" aria-labelledby="issuecreditnote-tab">
                                        <div class="inputrow">

                                            <br>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="scrollbar pb-3" id="style-2">
                                                        <table class="table table-bordered table-striped table-sm nowrap" id="dataTable2">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Rtn. No</th>
                                                                    <th>Return Type</th>
                                                                    <th>ASM</th>
                                                                    <th>Customer name</th>
                                                                    <th>Date</th>
                                                                    <th class="text-right">Return Total</th>
                                                                    <th class="text-right">Pay Total</th>
                                                                    <!-- <th class="text-right">Balance</th> -->
                                                                    <th>Actions</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if ($resultreultissuecredit->num_rows > 0) {
                                                                    while ($row = $resultreultissuecredit->fetch_assoc()) { ?>
                                                                        <tr>

                                                                            <td>CTN-<?php echo $row['idtbl_creditenote'] ?></td>
                                                                            <td>RTN-<?php echo $row['idtbl_return'] ?></td>
                                                                            <td><?php if($row['returntype'] == 1){echo "Customer Return";}else{echo "Damage Return";}?></td>
                                                                            <td><?php echo $row['asm'] ?></td>
                                                                            <td><?php echo $row['name'] ?></td>
                                                                            <td><?php echo $row['ctndate'] ?></td>
                                                                            <td class="text-right">Rs.<?php echo number_format($row['total'], 2); ?>
                                                                            <td class="text-right">Rs.<?php echo number_format($row['payAmount'], 2); ?>
                                                                                <!-- <td class="text-right">Rs.<?php echo number_format($row['total'] - $row['payAmount'], 2); ?> -->
                                                                            </td>
                                                                            <td> <button class="btn btn-outline-primary btn-sm rounded creditbtnView" id="<?php echo $row['idtbl_creditenote']; ?>"><i class="fas fa-eye"></i></button>
                                                                                <!-- <button class="btn btn-danger btn-sm rounded btnprint" id="<?php echo $row['idtbl_return']; ?>"><i class="fas fa-print"></i></button> -->
                                                                                <!-- <button class="btn btn-danger btn-sm rounded issuebtn" id="<?php echo $row['idtbl_return']; ?>"><i class="fas fa-receipt"></i></button> -->

                                                                            </td>
                                                                        </tr>
                                                                <?php }
                                                                } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <!-- Modal return details -->
                            <div class="modal fade" id="modalreturndetails" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                                    <div id="viewdetailqty"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal return details -->
                            <!-- <div class="modal fade" id="modalreturndetails" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                        </div> -->
                            <div class="modal fade" id="modelcreditissue" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header p-2">
                                            <h5 class="modal-title" id="viewmodaltitle"></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="viewdetailissuenote"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-danger btn-sm fa-pull-right" id="btnorderprint"><i class="fas fa-print"></i>&nbsp;Print Credit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>
        <!-- Modal order print -->
        <!-- <div class="modal fade" id="modalorderprint" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header p-2">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="viewdispatchprint"></div>
                    </div>


                </div>
            </div>
        </div> -->
        <div class="modal fade" id="paymentmodal" tabindex="-1" role="dialog" aria-labelledby="oLevel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header p-0 p-2">
                        <h5 class="modal-title" id="oLevelTitle">Issue Credit Receipt</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5">
                                <form id="formModal">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Return Amount</label>
                                        <input id="returnamount" name="returnamount" class="form-control form-control-sm" placeholder="Total Amount" readonly>
                                        <input type="hidden" id="returnamounthidden" value="0">
                                    </div>

                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="paymentMethod1" name="paymentMethod" class="custom-control-input" value="1" data-toggle="collapse" href="#collapseOne">
                                        <label class="custom-control-label" for="paymentMethod1">Cash</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="paymentMethod2" name="paymentMethod" class="custom-control-input" value="2" data-toggle="collapse" href="#collapseTwo">
                                        <label class="custom-control-label" for="paymentMethod2">INV Pay</label>
                                    </div>
                                    <div class="accordion" id="accordionExample">
                                        <div class="card shadow-none border-0">
                                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                <div class="card-body p-0">
                                                    <div class="form-group mb-1">
                                                        <label class="small font-weight-bold text-dark">Cash Advance</label>
                                                        <input id="paymentCash" name="paymentCash" type="text" class="form-control form-control-sm" placeholder="" required readonly>
                                                    </div>
                                                </div>

                                            </div>
                                            <div id="viewinvodetails"></div>
                                        </div>

                                        <div class="card shadow-none border-0">
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                <div class="card-body p-0">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <button name="submitBtnModal" type="button" id="submitBtnModal" class="btn btn-outline-primary btn-sm fa-pull-right"><i class="fas fa-file-invoice-dollar"></i>&nbsp;Add Payment</button>
                                        <input type="submit" class="d-none" id="hideSubmitModal">
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7">
                                <table class="table table-bordered table-sm table-striped" id="tblPaymentTypeModal">
                                    <thead>
                                        <th>Type</th>
                                        <th>Cash</th>
                                        <th>Invoice No</th>
                                        <th class="text-right">Invoice Total</th>
                                        <th class="text-right">Return Total</th>

                                    </thead>
                                    <tbody></tbody>
                                </table>
                                <div class="row">
                                    <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9 text-right">Total Amount :</div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 text-right">
                                        <div id="totAmount"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9 text-right">Paid Amount :</div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 text-right">
                                        <div id="paidAmount"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9 text-right">Balance Amount :</div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 text-right">
                                        <div id="blnsamnt"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9 text-right">Pay Amount :</div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 text-right">
                                        <div id="payAmount"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9 text-right">&nbsp;</div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 text-right">
                                        <hr class="border-dark">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9 text-right">Balance :</div>
                                    <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 text-right">
                                        <div id="balanceAmount"></div>
                                    </div>
                                </div>
                                <input type="hidden" id="hidePayAmount" value="0">
                                <input type="hidden" id="hidepaidAmount" value="0">
                                <input type="hidden" id="hideblnsamnt" value="0">
                                <input type="hidden" id="hideBalAmount" value="0">
                                <input type="hidden" id="hideAllBalAmount" value="0">
                                <textarea name="discountlist" id="discountlist" class="d-none"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" align="right">
                                <button class="btn btn-outline-danger btn-sm" id="btnIssueInv" disabled><i class="fas fa-file-pdf"></i>&nbsp;Issue Payment Receipt</button>
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
    $(document).ready(function() {
        $('#dataTable').DataTable({})

        document.getElementById('btnorderprint').addEventListener("click", print);

        $('#viewinvodetails').hide();
        $('.issuebtn').click(function() {
            var id = $(this).attr('id');

            $.ajax({
                type: "POST",
                data: {
                    id: id,
                },
                url: 'getprocess/getreturntotal.php',
                success: function(result) {
                    try {
                        var obj = JSON.parse(result);
                        if (obj.error) {
                            alert(obj.error);
                        } else {
                            getreturninv(id);
                            $('#returnamounthidden').val(obj.total);
                            $('#returnamount').val(addCommas(parseFloat(obj.total).toFixed(2)));
                            $('#totAmount').html(addCommas(parseFloat(obj.total).toFixed(2)));
                            $('#paidAmount').html(addCommas(parseFloat(obj.payAmount).toFixed(2)));
                            if (obj.payAmount == 0) {
                                $('#blnsamnt').html(addCommas(parseFloat(0).toFixed(2)));
                                $('#hideblnsamnt').val(0);
                            } else {
                                $('#blnsamnt').html(addCommas(parseFloat(obj.total - obj.payAmount).toFixed(2)));
                                $('#hideblnsamnt').val(obj.total - obj.payAmount);
                            }

                            $('#hidepaidAmount').val(obj.payAmount);

                            $('#paymentmodal').modal('show');
                        }

                    } catch (e) {
                        alert('Error parsing JSON: ' + e);
                    }

                    issuebtninvoice(id);
                },
                error: function(xhr, status, error) {
                    alert('AJAX error: ' + error);
                }

            });
        });


        $('input[type=radio][name=paymentMethod]').change(function() {
            if (this.value == '1') {
                $('#paymentBank').prop("disabled", true);
                $('#paymentCash').prop("readonly", false);
                $('#viewinvodetails').hide();
            } else {
                $('#paymentBank').prop("disabled", false);
                $('#paymentCash').prop("readonly", true);
                $('#viewinvodetails').show();
            }
        });



        var selectedItems = [];

        $(document).on('click', '.checkinvoice', function() {
            if ($(this).prop('checked')) {
                var id = $(this).attr('id');

                var idtbl_invoice = $(this).closest('tr').find('td:eq(1)').text();
                var total = $(this).closest('tr').find('td:eq(2)').text();
                var return_total = $(this).closest('tr').find('td:eq(4)').text();

                var item = {
                    id: id,
                    idtbl_invoice: idtbl_invoice,
                    total: total,
                    return_total: return_total,

                };

                selectedItems.push(item);
            } else {
                var id = $(this).attr('id');
                selectedItems = selectedItems.filter(function(item) {
                    return item.id !== id;
                });
            }
        })
        console.log(selectedItems);
        getselectedItems(selectedItems);
    })

    function getselectedItems(selectedItems) {

        $("#submitBtnModal").click(function() {

            if (!$("#formModal")[0].checkValidity()) {
                // If the form is invalid, submit it. The form won't actually submit;
                // this will just cause the browser to display the native HTML5 error messages.
                $("#hideSubmitModal").click();
            } else {
                var paymenttype = $('input[type=radio][name=paymentMethod]:checked').val();
                var paymentCash = parseFloat($('#paymentCash').val());
                var returnamount = parseFloat($('#returnamounthidden').val());

                if (paymenttype == 1) {
                    $('#tblPaymentTypeModal > tbody:last').append('<tr><td>Cash</td><td class="text-right">' + addCommas(parseFloat(paymentCash).toFixed(2)) + '</td><td class="">-</td><td class="">-</td><td>-</td><td class="d-none">' + paymentCash + '</td><td class="d-none">-</td><td class="d-none">1</td></tr>');
                    var paidAmount = parseFloat($('#hidePayAmount').val());
                    var PayAmount = parseFloat(paymentCash);
                    var paymentPayAmount = parseFloat($('#hideAllBalAmount').val());
                    var paidTotal = parseFloat($('#hidepaidAmount').val());
                    var hideblnsamnt = parseFloat($('#hideblnsamnt').val());
                    //alert(hideblnsamnt);

                    paidAmount = (paidAmount + PayAmount);

                    $('#payAmount').html((paidAmount).toFixed(2));
                    $('#hidePayAmount').val(paidAmount);
                    if (hideblnsamnt == 0) {
                        var balance = returnamount - paidAmount;
                    } else {
                        var balance = hideblnsamnt - paidAmount;
                    }

                    //  alert(balance);
                    $('#hideBalAmount').val(balance);
                    $('#balanceAmount').html((balance).toFixed(2));
                    $('#paymentCash').val('').prop('readonly', true);
                    $('#paymentMethod1').prop('checked', false);

                    $('#btnIssueInv').prop('disabled', false);
                } else {
                    $('#tblPaymentTypeModal > tbody').empty();
                    var paidAmount = parseFloat($('#hidePayAmount').val());
                    var hideblnsamnt = parseFloat($('#hideblnsamnt').val());
                    // alert(hideblnsamnt);
                    selectedItems.forEach(function(item) {
                        var total = addCommas(parseFloat(item.total).toFixed(2));
                        var totalhide = parseFloat(item.total);
                        var return_total = addCommas(parseFloat(item.return_total).toFixed(2));
                        var return_totalget = parseFloat(item.return_total);
                        var idtbl_invoice = parseFloat(item.idtbl_invoice);
                        $('#tblPaymentTypeModal > tbody:last').append('<tr><td>Invoice Payment</td><td class="">-</td><td>' + idtbl_invoice + '</td><td class="text-right">' + total + '</td><td class="text-right">' + return_total + '</td><td class="d-none rtntotal">' + return_totalget + '</td><td class="d-none">' + totalhide + '</td><td class="d-none">2</td></tr>');
                    });
                    var rtntotal = 0;
                    $(".rtntotal").each(function() {
                        rtntotal += parseFloat($(this).text());
                    });
                    var showrtntotal = parseFloat(rtntotal);

                    //  paidAmount = (paidAmount + showrtntotal);
                    if (hideblnsamnt == 0) {
                        var balance = returnamount - showrtntotal;
                    } else {
                        var balance = hideblnsamnt - showrtntotal;
                    }


                    $('#hideBalAmount').val(balance);
                    $('#balanceAmount').html(addCommas((balance).toFixed(2)));
                    $('#payAmount').html(addCommas((showrtntotal).toFixed(2)));
                    $('#hidePayAmount').val(showrtntotal);

                    $('#paymentMethod2').prop('checked', false);

                    $('#btnIssueInv').prop('disabled', false);
                }

                $('#collapseOne').collapse('hide');
                $('#collapseTwo').collapse('hide');
            }
        });
    }

    $('#returntype').change(function() {
        var type = $(this).val();

        if (type == 1) {
            $('#customerdiv').removeClass('d-none');
            $('#customer').prop('required', true);

            $('#supplierdiv').addClass('d-none');
            $('#supplier').prop('required', false);
        } else if (type == 2) {
            $('#customerdiv').addClass('d-none');
            $('#customer').prop('required', false);

            $('#supplierdiv').removeClass('d-none');
            $('#supplier').prop('required', true);
        } else {
            $('#customerdiv').addClass('d-none');
            $('#customer').prop('required', false);
            $('#supplierdiv').addClass('d-none');
            $('#supplier').prop('required', false);
        }
    });

    $('#dataTable tbody').on('click', '.btnprint', function() {
        var id = $(this).attr('id');
        // alert(id)
        $.ajax({
            type: "POST",
            data: {
                id: id
            },
            url: 'getprocess/getcreditnoteprint.php',
            success: function(result) {

                $('#viewdispatchprint').html(result);
                $('#modalorderprint').modal('show');
            }
        });
    });

    $('#dataTable tbody').on('click', '.btnView', function() {
        var id = $(this).attr('id');
        // alert("asd")
        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: 'getprocess/getreturnqtydetails.php',
            success: function(result) {
                // alert(result)
                $('#viewmodaltitle').html('Return No ' + id)
                $('#viewdetailqty').html(result);
                $('#modalreturndetails').modal('show');
            }
        });
    });
    $('#dataTable2 tbody').on('click', '.creditbtnView', function() {
        var id = $(this).attr('id');
        // alert(id)
        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: 'getprocess/getcreditissuedetails.php',
            success: function(result) {
                // alert(result)
                //  $('#modelcreditissue').html('Credit No ' + id)
                $('#viewdetailissuenote').html(result);
                $('#modelcreditissue').modal('show');
            }
        });
    });
    $('#dataTable tbody').on('click', '.btnQuantity', function() {
        var id = $(this).attr('id');

        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: 'getprocess/getquantitydetails.php',
            success: function(result) {
                // alert(result)
                $('#viewmodaltitle').html('Return No ' + id)
                $('#viewdetail').html(result);
                $('#modalquantitycheck').modal('show');
            }
        });
    });

    function issuebtninvoice(id) {
        $('#btnIssueInv').click(function() {
            jsonObj = [];
            $("#paymentDetailTable tbody tr").each(function() {
                item = {}
                $(this).find('td').each(function(col_idx) {
                    item["col_" + (col_idx + 1)] = $(this).text();
                });
                jsonObj.push(item);
            });
            // console.log(jsonObj);

            jsonObjOne = [];
            $("#tblPaymentTypeModal tbody tr").each(function() {
                item = {}
                $(this).find('td').each(function(col_idx) {
                    item["col_" + (col_idx + 1)] = $(this).text();
                });
                jsonObjOne.push(item);
            });
            console.log(jsonObjOne);

            var returnamount = parseFloat($('#returnamounthidden').val());
            var payAmount = $('#hidePayAmount').val();
            var balAmount = $('#hideBalAmount').val();
            var hideblnsamnt = parseFloat($('#hideblnsamnt').val());

            $.ajax({
                type: "POST",
                data: {
                    tblData: jsonObjOne,
                    returnamount: returnamount,
                    payAmount: payAmount,
                    balAmount: balAmount,
                    id: id,
                    hideblnsamnt: hideblnsamnt

                },
                url: 'process/crediteprocess.php',
                success: function(result) { //alert(result);
                    console.log(result);
                    var obj = JSON.parse(result);

                    action(obj.action);
                }
            });
        });


    }

    function getreturninv(id) {
        //  alert(id);
        $.ajax({
            type: "POST",
            data: {
                id: id
            },
            url: 'getprocess/getinvtable.php',
            success: function(result) {
                // alert(result)

                $('#viewinvodetails').html(result);

            }
        });

    }

    function print() {
        printJS({
            printable: 'viewdetailissuenote',
            type: 'html',
            style: '@page { size: portrait; margin:0.25cm; }',
            targetStyles: ['*']
        })
    }

    function addCommas(nStr) {
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

    function accept_confirm() {
        return confirm("Are you sure you want to Accept this?");
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

    function company_confirm() {
        return confirm("Are you sure this product send to company?");
    }

    function warehouse_confirm() {
        return confirm("Are you sure this product back to warehouse?");
    }

    function customer_confirm() {
        return confirm("Are you sure this product breturn back to customer?");
    }
</script>
<?php include "include/footer.php"; ?>