<?php
include "include/header.php";

$sqlreturncustomer = "SELECT `u`.`idtbl_return`, `u`.`returndate`, `u`.`total`, `ua`.`name`, `U`.`acceptance_status` FROM `tbl_return` as `u` LEFT JOIN `tbl_invoice` AS `ia` ON (`ia`.`idtbl_invoice` = `u`.`tbl_invoice_idtbl_invoice`) LEFT JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `ia`.`tbl_customer_idtbl_customer`)  WHERE `u`.`acceptance_status` IN (0,1) and `u`.`returntype` = '1'";
$resultreturncustomer = $conn->query($sqlreturncustomer);


// $sqlreturncustomerdetails="SELECT `u`.`idtbl_return`, `u`.`returndate`, `u`.`total`,`ua`.`name` FROM `tbl_return` AS `u` LEFT JOIN `tbl_invoice` AS `ia` ON (`ia`.`idtbl_invoice` = `u`.`tbl_invoice_idtbl_invoice`) LEFT JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `ia`.`tbl_customer_idtbl_customer`)  LEFT JOIN `tbl_supplier` AS `us` ON (`us`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) WHERE `u`.`acceptance_status` = '0' and `u`.`returntype` = '3'";
// $resultreturncustomerdetails =$conn-> query($sqlreturncustomerdetails);


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
                            <span>All Return</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Customer name</th>
                                                <th>Date</th>
                                                <th>Total</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($resultreturncustomer->num_rows > 0) {
                                                    while ($row = $resultreturncustomer->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $row['idtbl_return'] ?></td>
                                                <td><?php echo $row['name'] ?></td>
                                                <td><?php echo $row['returndate'] ?></td>
                                                <td class="text-right">Rs.<?php echo number_format($row['total'], 2); ?>
                                                </td>
                                                <td> <button class="btn btn-primary btn-sm rounded btnView"
                                                        id="<?php echo $row['idtbl_return']; ?>" name="<?php echo $row['acceptance_status']; ?>"><i
                                                            class="fas fa-eye"></i></button>
                                                <?php if($row['acceptance_status'] == 0) { ?>
                                                    <a href="process/statusacceptreturn.php?record=<?php echo $row['idtbl_return'] ?>&type=2"
                                                        onclick="return confirm('Are you sure you want to accept this return?');"
                                                        target="_self" class="btn btn-outline-danger btn-sm"><i
                                                            data-feather="x-square"></i></a>
                                                <?php }else{ ?>
                                                    <button  class="btn btn-outline-success btn-sm"><i
                                                            data-feather="check"></i></button>
                                                <?php }?>

                                                
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
        </main>
        <!-- Modal return details -->
        <div class="modal fade" id="modalreturndetails" data-backdrop="static" data-keyboard="false" tabindex="-1"
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

        <!-- Modal order print -->
        <div class="modal fade" id="modalorderprint" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
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

                    <div class="modal-footer">
                        <button class="btn btn-danger btn-sm fa-pull-right" id="btnorderprint"><i
                                class="fas fa-print"></i>&nbsp;Print Order</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Payment -->
        <div class="modal fade" id="paymentmodal" tabindex="-1" role="dialog" aria-labelledby="oLevel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header p-0 p-2">
                        <h5 class="modal-title" id="oLevelTitle">Issue Payment Receipt</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                <form id="formModal">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Return Amount</label>
                                        <input id="returnamount" name="returnamount" type="text"
                                            class="form-control form-control-sm" placeholder="Total Amount" readonly>
                                    </div>

                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="paymentMethod1" name="paymentMethod"
                                            class="custom-control-input" value="1" data-toggle="collapse"
                                            href="#collapseOne">
                                        <label class="custom-control-label" for="paymentMethod1">Cash</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="paymentMethod2" name="paymentMethod"
                                            class="custom-control-input" value="2" data-toggle="collapse"
                                            href="#collapseTwo">
                                        <label class="custom-control-label" for="paymentMethod2">INV Pay</label>
                                    </div>
                                    <div class="accordion" id="accordionExample">
                                        <div class="card shadow-none border-0">
                                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                                data-parent="#accordionExample">
                                                <div class="card-body p-0">
                                                    <div class="form-group mb-1">
                                                        <label class="small font-weight-bold text-dark">Cash
                                                            Advance</label>
                                                        <input id="paymentCash" name="paymentCash" type="text"
                                                            class="form-control form-control-sm" placeholder="" required
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card shadow-none border-0">
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                                data-parent="#accordionExample">
                                                <div class="card-body p-0">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <button name="submitBtnModal" type="button" id="submitBtnModal"
                                            class="btn btn-outline-primary btn-sm fa-pull-right"><i
                                                class="fas fa-file-invoice-dollar"></i>&nbsp;Add Payment</button>
                                        <input type="submit" class="d-none" id="hideSubmitModal">
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9">
                                <table class="table table-bordered table-sm table-striped" id="tblPaymentTypeModal">
                                    <thead>
                                        <th>Type</th>
                                        <th class="text-right">Cash</th>
                                        <th class="text-right">Cheque / Deposit</th>
                                        <th>Che No</th>
                                        <th>Receipt</th>
                                        <th>Che Date</th>
                                        <th>Bank</th>
                                        <th class="d-none">BankID</th>
                                        <th class="d-none">paymethod</th>
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
                                <input type="hidden" id="hideBalAmount" value="0">
                                <input type="hidden" id="hideAllBalAmount" value="0">
                                <textarea name="discountlist" id="discountlist" class="d-none"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" align="right">
                                <button class="btn btn-outline-danger btn-sm" id="btnIssueInv" disabled><i
                                        class="fas fa-file-pdf"></i>&nbsp;Issue Payment Receipt</button>
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
    $(document).ready(function () {
        document.getElementById('btnorderprint').addEventListener("click", print);

        $('.issuebtn').click(function () {
            var id = $(this).attr('id');

            $.ajax({
                type: "POST",
                data: {
                    id: id,
                },
                url: 'process/returnissueprocess.php',
                success: function (result) {

                    // var obj = JSON.parse(result);
                    action(result);

                },

            });
        });

        $('input[type=radio][name=paymentMethod]').change(function () {
            if (this.value == '1') {
                $('#paymentBank').prop("disabled", true);
                $('#paymentCash').prop("readonly", false);
            } else {
                $('#paymentBank').prop("disabled", false);
                $('#paymentCash').prop("readonly", true);
            }
        });

        $("#submitBtnModal").click(function () {
            if (!$("#formModal")[0].checkValidity()) {
                // If the form is invalid, submit it. The form won't actually submit;
                // this will just cause the browser to display the native HTML5 error messages.
                $("#hideSubmitModal").click();
            } else {
                var paymenttype = $('input[type=radio][name=paymentMethod]:checked').val();
                var paymentCash = $('#paymentCash').val();
                var returnamount = $('#returnamount').val();
                alert(returnamount);
                if (paymenttype == 1) {
                    $('#tblPaymentTypeModal > tbody:last').append(
                        '<tr><td>Cash</td><td class="text-right">' + parseFloat(paymentCash)
                        .toFixed(2) +
                        '</td><td class="">-</td><td class="">-</td><td>-</td><td>-</td><td>-</td><td class="d-none">1</td><td class="d-none">1</td></tr>'
                    );
                    var paidAmount = parseFloat($('#hidePayAmount').val());
                    var PayAmount = parseFloat(paymentCash);
                    var paymentPayAmount = parseFloat($('#hideAllBalAmount').val());

                    paidAmount = (paidAmount + PayAmount);
                    var balance = (returnamount - paidAmount);
                    $('#hideBalAmount').val(balance);
                    $('#balanceAmount').html((balance).toFixed(2));
                    $('#payAmount').html((paidAmount).toFixed(2));
                    $('#hidePayAmount').val(paidAmount);

                    $('#paymentCash').val('').prop('readonly', true);
                    $('#paymentMethod1').prop('checked', false);

                    $('#btnIssueInv').prop('disabled', false);
                } else {
                    $('#tblPaymentTypeModal > tbody:last').append(
                        '<tr><td>Bank / Cheque</td><td class="">-</td><td class="text-right">' +
                        parseFloat(paymentCheque).toFixed(2) + '</td><td class="">' +
                        paymentChequeNum + '</td><td>' + paymentReceiptNum + '</td><td>' +
                        paymentchequeDate + '</td><td>' + paymentBank + '</td><td class="d-none">' +
                        paymentBankID + '</td><td class="d-none">2</td></tr>');

                    var paidAmount = parseFloat($('#hidePayAmount').val());
                    var PayAmount = parseFloat(paymentCheque);
                    var paymentPayAmount = parseFloat($('#hideAllBalAmount').val());

                    paidAmount = (paidAmount + PayAmount);
                    var balance = (paymentPayAmount - paidAmount);
                    $('#hideBalAmount').val(balance);
                    $('#balanceAmount').html((balance).toFixed(2));
                    $('#payAmount').html((paidAmount).toFixed(2));
                    $('#hidePayAmount').val(paidAmount);

                    $('#paymentCheque').val('').prop('readonly', true);
                    $('#paymentChequeNum').val('').prop('readonly', true);
                    $('#paymentReceiptNum').val('').prop('readonly', true);
                    $('#paymentchequeDate').val('').prop('readonly', true);
                    $('#paymentBank').val('').prop('disabled', true);
                    $('#paymentMethod2').prop('checked', false);

                    $('#btnIssueInv').prop('disabled', false);
                }

                $('#collapseOne').collapse('hide');
                $('#collapseTwo').collapse('hide');
            }
        });
        $('#btnIssueInv').click(function () {
            jsonObj = [];
            $("#paymentDetailTable tbody tr").each(function () {
                item = {}
                $(this).find('td').each(function (col_idx) {
                    item["col_" + (col_idx + 1)] = $(this).text();
                });
                jsonObj.push(item);
            });
            // console.log(jsonObj);

            jsonObjOne = [];
            $("#tblPaymentTypeModal tbody tr").each(function () {
                item = {}
                $(this).find('td').each(function (col_idx) {
                    item["col_" + (col_idx + 1)] = $(this).text();
                });
                jsonObjOne.push(item);
            });
            // console.log(jsonObjOne);

            var totAmount = $('#paymentPayAmount').val();
            var payAmount = $('#hidePayAmount').val();
            var balAmount = $('#hideBalAmount').val();
            var discountlist = $('#discountlist').val();

            $.ajax({
                type: "POST",
                data: {
                    tblData: jsonObj,
                    tblPayData: jsonObjOne,
                    totAmount: totAmount,
                    payAmount: payAmount,
                    balAmount: balAmount,
                    discountlist: discountlist
                },
                url: 'process/invoicepaymentprocess.php',
                success: function (result) { //alert(result);
                    console.log(result);
                    var obj = JSON.parse(result);
                    if (obj.paymentinvoice > 0) {
                        $('#paymentmodal').modal('hide');
                        paymentreceiptview(obj.paymentinvoice);
                        $('#paymentmodal').modal('hide');
                        $('#modalpaymentreceipt').modal('show');
                        $('#discountlist').val('');
                    }
                    action(obj.action);
                }
            });
        });
    })

    $('#returntype').change(function () {
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

    $('#dataTable tbody').on('click', '.btnprint', function () {
        var id = $(this).attr('id');
        // alert(id)
        $.ajax({
            type: "POST",
            data: {
                id: id
            },
            url: 'getprocess/getreturnprint.php',
            success: function (result) {

                $('#viewdispatchprint').html(result);
                $('#modalorderprint').modal('show');
            }
        });
    });

    $('#dataTable tbody').on('click', '.btnView', function () {
        var id = $(this).attr('id');
        var acceptancestatus = $(this).attr('name');
        // alert("asd")
        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: 'getprocess/getreturndetails.php',
            success: function (result) {
                // alert(result)
                $('#viewmodaltitle').html('Return No ' + id)
                $('#viewdetail').html(result);
                $('#modalreturndetails').modal('show');
                if(acceptancestatus == 1){
                    $('#submitBtn').attr('disabled', true);
                }else{
                    $('#submitBtn').attr('disabled', false);
                }
                
            }
        });
    });

    $('#dataTable tbody').on('click', '.btnQuantity', function () {
        var id = $(this).attr('id');

        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: 'getprocess/getquantitydetails.php',
            success: function (result) {
                // alert(result)
                $('#viewmodaltitle').html('Return No ' + id)
                $('#quantitydetail').html(result);
                $('#modalquantitycheck').modal('show');
            }
        });
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

    function print() {
        printJS({
            printable: 'viewdispatchprint',
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

    function credit_confirm() {
        return confirm("Are you sure you want to create credit note?");
    }
</script>
<?php include "include/footer.php"; ?>