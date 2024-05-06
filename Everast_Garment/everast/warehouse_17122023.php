<?php 
include "include/header.php";  

$sql="SELECT * FROM `tbl_porder` WHERE `confirmstatus` IN (1,0,2)";
$result =$conn-> query($sql); 

$sqlproduct="SELECT `idtbl_product`, `product_name` FROM `tbl_product` WHERE `status`=1";
$resultproduct =$conn-> query($sqlproduct); 

$sqlbank="SELECT `idtbl_bank`, `bankname` FROM `tbl_bank` WHERE `status`=1 AND `idtbl_bank`>1";
$resultbank =$conn-> query($sqlbank); 

$sqlreplist="SELECT `idtbl_employee`, `name` FROM `tbl_employee` WHERE `tbl_user_type_idtbl_user_type`=7 AND `status`=1";
$resultreplist =$conn-> query($sqlreplist);

$sqlarealist="SELECT `idtbl_area`, `area` FROM `tbl_area` WHERE `status`=1";
$resultarealist =$conn-> query($sqlarealist);

$sqlhelperlist="SELECT `idtbl_employee`, `name` FROM `tbl_employee` WHERE `tbl_user_type_idtbl_user_type`=5 AND `status`=1";
$resulthelperlist =$conn-> query($sqlhelperlist);

$sqlquerycompany="SELECT `idtbl_query_company`, `name` FROM `tbl_query_company` WHERE `status`=1";
$resultquerycompany =$conn-> query($sqlquerycompany);

include "include/topnavbar.php"; 
?>
<style>
    .tableprint {
        table-layout: fixed;
    }
</style>
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
                            <div class="page-header-icon"><i class="fas fa-warehouse"></i></div>
                            <span>Warehouse</span>
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
                                                <th>Date</th>
                                                <th>Order No</th>
                                                <th>Rep Name</th>
                                                <th>Area</th>
                                                <th>Customer</th>
                                                <th class="text-right">Subtotal</th>
                                                <th class="text-right">Discount</th>
                                                <th class="text-right">Nettotal</th>
                                                <th class="text-center">Confirm</th>
                                                <th class="text-center">Ship</th>
                                                <th class="text-center">Delivery</th>
                                                <th class="text-center">Tracking No</th>
                                                <th class="text-right">Actions</th>
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
<!-- Modal order view -->
<div class="modal fade" id="modalorderview" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header p-2">
                <h6 class="modal-title" id="viewmodaltitle"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-sm small" id="tableorderview">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="d-none">ProductID</th>
                            <th class="text-center"> Qty</th>
                            <th class=""> Free Product</th>
                            <th class="d-none"> Freeproductid</th>
                            <th class="text-center"> Free Qty</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div class="row">
                    <div class="col-9 text-right">
                        <h5 class="font-weight-600">Subtotal</h5>
                    </div>
                    <div class="col-3 text-right">
                        <h5 class="font-weight-600" id="divsubtotalview">Subtotal: Rs. 0.00</h5>
                    </div>
                    <div class="col-9 text-right">
                        <h5 class="font-weight-600">Discount%</h5>
                    </div>
                    <div class="col-3 text-right">
                        <h5 class="font-weight-600" id="discountperview">Discount%: Rs. 0.00</h5>
                    </div>
                    <div class="col-9 text-right">
                        <h5 class="font-weight-600">Total Discount</h5>
                    </div>
                    <div class="col-3 text-right">
                        <h5 class="font-weight-600" id="divdiscountview">Rs. 0.00</h5>
                    </div>
                    <div class="col-9 text-right">
                        <h1 class="font-weight-600">Nettotal</h1>
                    </div>
                    <div class="col-3 text-right">
                        <h1 class="font-weight-600" id="divtotalview">Rs. 0.00</h1>
                    </div>
                    <div class="col-12">
                        <h6 class="title-style"><span>Remark Information</span></h6>
                    </div>
                    <div class="col-12">
                        <div id="remarkview"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Invoice Create -->
<div class="modal fade" id="modalinvoicecreate" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header p-2">
                <h6 class="modal-title" id="viewmodaltitle"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
                        <form id="hiddenform">
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Order Date*</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control dpd1a" placeholder="" name="orderdate"
                                        id="orderdate" value="" readonly>
                                    <div class="input-group-append">
                                        <span class="btn btn-light border-gray-500"><i
                                                class="far fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Rep Name*</label>
                                <select class="form-control form-control-sm" name="repname" id="repname" required>
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Area*</label>
                                <select class="form-control form-control-sm" name="area" id="area" required>
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Customer*</label>
                                <select class="form-control form-control-sm" name="customer" id="customer" required>
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <!-- <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Query Company*</label>
                                <select class="form-control form-control-sm" name="company" id="company" required>
                                    <option value="">Select</option>
                                    <?php if($resultquerycompany->num_rows > 0) {while ($row = $resultquerycompany-> fetch_assoc()) { ?>
                                    <option value="<?php echo $row['idtbl_query_company'] ?>">
                                        <?php echo $row['name'] ?></option>
                                    <?php }} ?>
                                </select>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Tracking number*</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" placeholder="" name="trackingnumber"
                                        id="trackingnumber" value="" required>
                                </div>
                                <input id = "hiddensubmitbtn" class = "d-none" type="submit">
                            </div> -->

                        </form>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">
                        <table class="table table-striped table-bordered table-sm small" id="invoicetable">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th class="d-none">ProductID</th>
                                    <th class="d-none">Unitprice</th>
                                    <th class="d-none">Saleprice</th>
                                    <th class="text-center">Qty</th>
                                    <th class="">Free Product</th>
                                    <th class="d-none">Freeproductid</th>
                                    <th class="text-center">Free Qty</th>
                                    <th class="text-center">Total Qty</th>
                                    <th class="text-right">Sale Price</th>
                                    <th class="d-none">HideTotal</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="row">
                            <div class="col-9 text-right">
                                <h5 class="font-weight-600">Subtotal</h5>
                            </div>
                            <div class="col-3 text-right">
                                <h5 class="font-weight-600" id="divsubtotal">Subtotal: Rs. 0.00</h5>
                            </div>
                            <div class="col-9 text-right">
                                <h5 class="font-weight-600">Discount%</h5>
                            </div>
                            <div class="col-3 text-right">
                                <h5 class="font-weight-600" id="divdiscountpercentage">Subtotal: Rs. 0.00</h5>
                            </div>
                            <div class="col-9 text-right">
                                <h5 class="font-weight-600">Discount</h5>
                            </div>
                            <div class="col-3 text-right">
                                <h5 class="font-weight-600" id="divdiscount">Rs. 0.00</h5>
                            </div>
                            <div class="col-9 text-right">
                                <h1 class="font-weight-600">Nettotal</h1>
                            </div>
                            <div class="col-3 text-right">
                                <h1 class="font-weight-600" id="divtotal">Rs. 0.00</h1>
                            </div>
                            <input type="hidden" id="hidetotalorder" value="0">
                            <input type="hidden" id="hideorderid" value="0">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="small font-weight-bold text-dark">Remark</label>
                            <textarea name="remark" id="remark" class="form-control form-control-sm"></textarea>
                        </div>
                        <div class="form-group mt-2">
                            <button type="button" id="btncreateinvoice"
                                class="btn btn-outline-primary btn-sm fa-pull-right"
                                <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-save"></i>&nbsp;Create
                                Invoice</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
    $(document).ready(function () {
        checkdayendprocess();
        $("#helpername").select2();

        $('body').tooltip({
            selector: '[data-toggle="tooltip"]'
        });
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'hover'
        });

        var addcheck = '<?php echo $addcheck; ?>';
        var editcheck = '<?php echo $editcheck; ?>';
        var statuscheck = '<?php echo $statuscheck; ?>';
        var deletecheck = '<?php echo $deletecheck; ?>';

        $('#dataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: "scripts/warehouseporderlist.php",
                type: "POST", // you can use GET
            },
            "order": [
                [0, "desc"]
            ],
            "columns": [{
                    "data": "idtbl_porder"
                },
                {
                    "data": "orderdate"
                },
                {
                    "targets": -1,
                    "className": '',
                    "data": null,
                    "render": function (data, type, full) {
                        return 'PO0' + full['idtbl_porder'];
                    }
                },
                {
                    "data": "repname"
                },
                {
                    "data": "area"
                },
                {
                    "data": "cusname"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function (data, type, full) {
                        return parseFloat(full['subtotal']).toFixed(2);
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function (data, type, full) {
                        return parseFloat(full['disamount']).toFixed(2);
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function (data, type, full) {
                        return parseFloat(full['nettotal']).toFixed(2);
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-center',
                    "data": null,
                    "render": function (data, type, full) {
                        var html = '';
                        if (full['confirmstatus'] == 1) {
                            html += '<i class="fas fa-check text-success"></i>&nbsp;Confirm';
                        } else if (full['confirmstatus'] == 2) {
                            html += '<i class="fas fa-times text-danger"></i>&nbsp;Cancelled';
                        } else {
                            html += '<i class="fas fa-times text-danger"></i>&nbsp;Not Confirm';
                        }
                        return html;
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-center',
                    "data": null,
                    "render": function (data, type, full) {
                        var html = '';
                        if (full['shipstatus'] == 1) {
                            html += '<i class="fas fa-check text-success"></i>&nbsp;Shipped';
                        } else {
                            html += '<i class="fas fa-times text-danger"></i>&nbsp;Not Shipped';
                        }
                        return html;
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-center',
                    "data": null,
                    "render": function (data, type, full) {
                        var html = '';
                        if (full['deliverystatus'] == 1) {
                            html += '<i class="fas fa-check text-success"></i>&nbsp;Delivered';
                        } else {
                            html +=
                                '<i class="fas fa-times text-danger"></i>&nbsp;Not Delivered';
                        }
                        return html;
                    }
                },
                {
                    "data": "trackingno"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function (data, type, full) {
                        var button = '';
                        button +=
                            '<button class="btn btn-outline-dark btn-sm btnview mr-1" id="' +
                            full['idtbl_porder'] + '"><i class="far fa-eye"></i></button>';
                        // button+='<button class="btn btn-outline-primary btn-sm mr-1 btnprint" data-toggle="tooltip" data-placement="bottom" title="Print Order" id="'+full['idtbl_porder']+'"><i class="fas fa-print"></i></button>';
                        button +=
                            '<button class="btn btn-outline-success btn-sm mr-1" data-toggle="tooltip" data-placement="bottom" title="Accepted Order"><i class="fas fa-check"></i></button>';
                        button +=
                            '<button class="btn btn-outline-primary btn-sm mr-1 btninvoice" data-toggle="tooltip" data-placement="bottom" title="Create Invoice" id="' +
                            full['idtbl_porder'] + '"><i class="far fa-file-alt"></i></button>';

                        return button;
                    }
                }
            ]
        });
        $('#dataTable tbody').on('click', '.btninvoice', function () {
            var id = $(this).attr('id');
            $('#hideorderid').val(id);
            $.ajax({
                type: "POST",
                data: {
                    orderID: id
                },
                url: 'getprocess/getorderdetailaccoorderid.php',
                success: function (result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#orderdate').val(obj.orderdate);

                    let htmlrep = '';
                    htmlrep += '<option value="' + obj.idtbl_employee + '">' + obj.repname +
                        '</option>'
                    $('#repname').empty().append(htmlrep);

                    let htmlarea = '';
                    htmlarea += '<option value="' + obj.idtbl_area + '">' + obj.area +
                        '</option>'
                    $('#area').empty().append(htmlarea);

                    let htmlcustomer = '';
                    htmlcustomer += '<option value="' + obj.idtbl_customer + '">' + obj
                        .cusname + '</option>'
                    $('#customer').empty().append(htmlcustomer);

                    $('#divsubtotal').html(addCommas(parseFloat(obj.subtotal).toFixed(2)));
                    $('#divdiscount').html(addCommas(parseFloat(obj.disamount).toFixed(2)));
                    $('#divdiscountpercentage').html(obj.discount + '%');
                    $('#divtotal').html(addCommas(parseFloat(obj.nettotal).toFixed(2)));
                    $('#hidetotalorder').val(obj.nettotal);
                    $('#remark').val(obj.remark);

                    $('#invoicetable > tbody:last').empty();
                    var objfirst = obj.datainfo;
                    $.each(objfirst, function (i, item) {
                        //alert(objfirst[i].id);

                        let saleprice = parseFloat(objfirst[i].saleprice);
                        let qty = parseFloat(objfirst[i].qty);
                        let freeqty = parseFloat(objfirst[i].freeqty);
                        let totqty = parseFloat(qty + freeqty);

                        let itemtotal = parseFloat(saleprice * qty).toFixed(2);

                        $('#invoicetable > tbody:last').append('<tr><td>' +
                            objfirst[i].product + '</td><td class="d-none">' +
                            objfirst[i].productid + '</td><td class="d-none">' +
                            objfirst[i].unitprice + '</td><td class="d-none">' +
                            objfirst[i].saleprice +
                            '</td><td class="text-center editnewqty">' +
                            objfirst[i].qty + '</td><td class="">' + objfirst[i]
                            .freeproduct + '</td><td class="d-none">' +
                            objfirst[i].freeproductid +
                            '</td><td class="text-center editfreeqty">' +
                            objfirst[i].freeqty +
                            '</td><td class="text-center">' + totqty +
                            '</td><td class="text-right">' + addCommas(
                                parseFloat(objfirst[i].saleprice).toFixed(2)) +
                            '</td><td class="total d-none">' + itemtotal +
                            '</td><td class="text-right">' + addCommas(
                                itemtotal) + '</td></tr>');
                    });

                    $('#modalinvoicecreate').modal('show');
                }
            });
        });
        $('#invoicetable tbody').on('click', '.editnewqty', function (e) {
            var row = $(this);
            // var rowid = row.closest("tr").find('td:eq(0)').text();
            // var selectvalueone = $('.optionpiorityone' + rowid).val();
            // row.closest("tr").find('td:eq(7)').text(selectvalueone);

            e.preventDefault();
            e.stopImmediatePropagation();

            $this = $(this);
            if ($this.data('editing')) return;

            var val = $this.text();

            $this.empty();
            $this.data('editing', true);

            $('<input type="Text" class="form-control form-control-sm optionnewqty">').val(val)
                .appendTo($this);
            textremove('.optionnewqty', row);
        });
        $('#invoicetable tbody').on('click', '.editfreeqty', function (e) {
            var row = $(this);
            // var rowid = row.closest("tr").find('td:eq(0)').text();
            // var selectvalueone = $('.optionpiorityone' + rowid).val();
            // row.closest("tr").find('td:eq(7)').text(selectvalueone);

            e.preventDefault();
            e.stopImmediatePropagation();

            $this = $(this);
            if ($this.data('editing')) return;

            var val = $this.text();

            $this.empty();
            $this.data('editing', true);

            $('<input type="Text" class="form-control form-control-sm optionfreeqty">').val(val)
                .appendTo($this);
            textremove('.optionfreeqty', row);
        });

        $('#btncreateinvoice').click(function () { //alert('IN');
            if (!$("#hiddenform")[0].checkValidity()) {
                // If the form is invalid, submit it. The form won't actually submit;
                // this will just cause the browser to display the native HTML5 error messages.
                $("#hiddensubmitbtn").click();
            } else {
                var tbody = $("#invoicetable tbody");

                if (tbody.children().length > 0) {
                    jsonObj = [];
                    $("#invoicetable tbody tr").each(function () {
                        item = {}
                        $(this).find('td').each(function (col_idx) {
                            item["col_" + (col_idx + 1)] = $(this).text();
                        });
                        jsonObj.push(item);
                    });


                    var orderdate = $('#orderdate').val();
                    var remark = $('#remark').val();
                    var repname = $('#repname').val();
                    var area = $('#area').val();
                    var customer = $('#customer').val();
                    var total = $('#hidetotalorder').val();
                    var orderID = $('#hideorderid').val();
                    // var companyId = $('#company').val();
                    // var trackingnumber = $('#trackingnumber').val();

                    $.ajax({
                        type: "POST",
                        data: {
                            tableData: jsonObj,
                            orderdate: orderdate,
                            total: total,
                            remark: remark,
                            repname: repname,
                            area: area,
                            customer: customer,
                            orderID: orderID,
                            // companyId: companyId,
                            // trackingnumber: trackingnumber
                        },
                        url: 'process/createinvoiceaccoporderprocess.php',
                        success: function (result) { //alert(result);
                            console.log(result);
                            $('#modalinvoicecreate').modal('hide');
                            action(result);
                            // location.reload();
                        }
                    });
                }
            }
        });

        $('.dpd1a').datepicker({
            uiLibrary: 'bootstrap4',
            autoclose: 'true',
            todayHighlight: true,
            startDate: 'today',
            format: 'yyyy-mm-dd'
        });

        // Order view part
        $('#dataTable tbody').on('click', '.btnview', function () {
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                data: {
                    orderID: id
                },
                url: 'getprocess/getcusorderlistaccoorderid.php',
                success: function (result) { //alert(result);
                    var obj = JSON.parse(result);

                    $('#divsubtotalview').html(obj.subtotal);
                    $('#divdiscountview').html(obj.disamount);
                    $('#divtotalview').html(obj.nettotalshow);
                    $('#remarkview').html(obj.remark);
                    $('#discountperview').html(obj.discount+ '%');
                    $('#viewmodaltitle').html('Order No: PO-' + id);

                    var objfirst = obj.tablelist;
                    $.each(objfirst, function (i, item) {
                        //alert(objfirst[i].id);

                        $('#tableorderview > tbody:last').append('<tr><td>' +
                            objfirst[i].productname +
                            '</td><td class="d-none">' + objfirst[i].productid +
                            '</td><td class="text-center">' + objfirst[i]
                            .newqty + '</td><td class="">' + objfirst[i]
                            .freeproduct + '</td><td class="d-none">' +
                            objfirst[i].freeproductid +
                            '</td><td class="text-center">' + objfirst[i]
                            .freeqty + '</td><td class="text-right total">' +
                            objfirst[i].total + '</td></tr>');
                    });
                    $('#modalorderview').modal('show');
                }
            });
        });
        $('#modalorderview').on('hidden.bs.modal', function (e) {
            $('#tableorderview > tbody').html('');
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

    function print() {
        printJS({
            printable: 'viewdispatchprint',
            type: 'html',
            style: '@page { size: landscape; margin:0.25cm; }',
            targetStyles: ['*']
        })
    }

    function tabletotal() {
        var sum = 0;
        $(".totaldispatch").each(function () {
            sum += parseFloat($(this).text());
        });

        var showsum = addCommas(parseFloat(sum).toFixed(2));

        $('#divtotaldispatch').html('Rs. ' + showsum);
        $('#hidetotalorderdispatch').val(sum);
    }

    function delete_confirm() {
        return confirm("Are you sure you want to remove this?");
    }

    function checkdayendprocess() {
        $.ajax({
            type: "POST",
            data: {

            },
            url: 'getprocess/getstatuslastdayendinfo.php',
            success: function (result) { //alert(result);
                if (result == 1) {
                    $('#viewmessage').html("Can't create anything, because today transaction is end");
                    $('#warningDayEndModal').modal('show');
                } else if (result == 0) {
                    $('#viewmessage').html(
                        "Can't create anythind, because yesterday day end process end not yet.");
                    $('#warningDayEndModal').modal('show');
                }
            }
        });
    }

    function textremove(classname, row) {
        $('#invoicetable tbody').on('keyup', classname, function (e) {
            if (e.keyCode === 13) {
                $this = $(this);
                var val = $this.val();
                var td = $this.closest('td');
                td.empty().html(val).data('editing', false);

                var rowID = row.closest("td").parent()[0].rowIndex;
                var unitprice = parseFloat(row.closest("tr").find('td:eq(2)').text());
                var saleprice = parseFloat(row.closest("tr").find('td:eq(3)').text());

                var newqty = parseFloat(row.closest("tr").find('td:eq(4)').text());
                var freeqty = parseFloat(row.closest("tr").find('td:eq(5)').text());

                var totqty = newqty + freeqty;
                var totnew = newqty * saleprice;

                var total = parseFloat(totnew).toFixed(2);
                var showtotal = addCommas(total);

                $('#invoicetable').find('tr').eq(rowID).find('td:eq(6)').text(totqty);
                $('#invoicetable').find('tr').eq(rowID).find('td:eq(8)').text(total);
                $('#invoicetable').find('tr').eq(rowID).find('td:eq(9)').text(showtotal);

                tabletotal();
            }
        });
    }

    function tabletotal() {
        var sum = 0;
        $(".total").each(function () {
            sum += parseFloat($(this).text());
        });

        var showsum = addCommas(parseFloat(sum).toFixed(2));

        $('#divtotal').html('Rs. ' + showsum);
        $('#hidetotalorder').val(sum);
    }
</script>
<?php include "include/footer.php"; ?>