<?php 
include "include/header.php";  

$sql="SELECT `tbl_invoice`.`idtbl_invoice`, `tbl_invoice`.`date`, `tbl_invoice`.`total`, `tbl_invoice`.`paymentcomplete`, `tbl_customer`.`name`, `tbl_employee`.`name` AS `saleref`, `tbl_area`.`area` FROM `tbl_invoice` LEFT JOIN `tbl_customer` ON `tbl_customer`.`idtbl_customer`=`tbl_invoice`.`tbl_customer_idtbl_customer` LEFT JOIN `tbl_employee` ON `tbl_employee`.`idtbl_employee`=`tbl_invoice`.`ref_id` LEFT JOIN `tbl_area` ON `tbl_area`.`idtbl_area`=`tbl_invoice`.`tbl_area_idtbl_area` WHERE `tbl_invoice`.`status`=1";
$result =$conn-> query($sql); 

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
                            <div class="page-header-icon"><i data-feather="file"></i></div>
                            <span>Invoice View</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card row">
                    <div class="col-md-12 mt-3">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="inputrow">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="scrollbar pb-3" id="style-2">
                                            <table class="table table-bordered table-striped table-sm nowrap"
                                                id="dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>Invoice</th>
                                                        <th>ASM or CSM</th>
                                                        <th>Date</th>
                                                        <th>Customer</th>
                                                        <th>Sale Rep</th>
                                                        <th>Area</th>
                                                        <th class="text-right">Total</th>
                                                        <th>Payment</th>

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

                </div>
            </div>
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>

<!-- Modal Invoice Receipt -->
<div class="modal fade" id="modalinvoicereceipt" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe class="embed-responsive-item w-100" height="600px" id="iframeModal" src=""></iframe>
            </div>
        </div>
    </div>
</div>


<!-- Modal Warning -->
<div class="modal fade" style="z-index: 2000; " id="warningModal" data-backdrop="static" data-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body bg-danger text-white text-center">
                Can't cancel this invoice, because firstly cancel payment receipt. Thank you.
            </div>
            <div class="modal-footer bg-danger rounded-0">
                <button type="button" class="btn btn-outline-light btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal Cancel Reason -->
<div class="modal fade" id="modalcancelreason" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Quantity check</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="" action="process/statusinvoice.php" method="get" autocomplete="off">

                    <div class="col-md-12">
                        <div class="form-group mb-1">
                            <label class="small font-weight-bold text-dark">Cancel Reason*</label>
                            <textarea class="form-control form-control-sm" name="reason" id="reason"
                                required></textarea>
                        </div>
                    </div>
                    <div>
                        <input type="hidden" id="record" name="record">
                        <input type="hidden" id="type" name="type" value="3">

                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" id="qtySubmitBtn"
                            class="btn btn-outline-primary btn-sm px-4 fa-pull-right"
                            <?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Submit</button>
                    </div>
                    <input type="hidden" name="hiddenstatus" id="hiddenstatus" value="">
                </form>
            </div>

        </div>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
    $(document).ready(function () {
        var addcheck = '<?php echo $addcheck; ?>';
        var editcheck = '<?php echo $editcheck; ?>';
        var statuscheck = '<?php echo $statuscheck; ?>';
        var deletecheck = '<?php echo $deletecheck; ?>';

        $('#dataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: "scripts/invoiceviewlist.php",
                type: "POST", // you can use GET
            },
            "order": [
                [0, "desc"]
            ],
            "columns": [{
                    "targets": -1,
                    "className": '',
                    "data": null,
                    "render": function (data, type, full) {
                        return 'INV-' + full['idtbl_invoice'];
                    }
                },
                {
                    "data": "empname"
                },
                {
                    "data": "date"
                },

                {
                    "data": "name"
                },
                {
                    "data": "salepep"
                },
                {
                    "data": "area"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function (data, type, full) {
                        var payment = addCommas(parseFloat(full['total']).toFixed(2));
                        return payment;
                    }
                },
                {
                    "targets": -1,
                    "className": '',
                    "data": null,
                    "render": function (data, type, full) {
                        if (full['paymentcomplete'] == 1) {
                            return 'Complete';
                        } else {
                            return 'Pending';
                        }
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function (data, type, full) {
                        var button = '';
                        button +=
                            '<button class="btn btn-outline-dark btn-sm btnView mr-1" id="' +
                            full['idtbl_invoice'] +
                            '"><i class="fas fa-eye"></i></button> ';

                        // button +=
                        //     '<button class="btn btn-outline-primary btn-sm btnCheck mr-1" id="' +
                        //     full['idtbl_invoice'] +
                        //     '"><i class="fas fa-eye"></i></button> ';

                        if (full['paymentcomplete'] == 0) {
                            // button += '<a href="process/statusinvoice.php?record=' + full[
                            //         'idtbl_invoice'] +
                            //     '&type=3" onclick="return delete_confirm()" target="_self" class="btn btn-outline-danger btn-sm ';
                            if (full['shipstatus'] == 0 && full['status'] == 1) {
                                button +=
                                    '<button class="btn btn-outline-danger btn-sm mr-1 btnship" data-toggle="tooltip" data-placement="bottom" title="Order not ship" id="' +
                                    full['idtbl_porder'] +
                                    '"><i class="fas fa-dolly"></i></button>';
                            } else if (full['status'] == 1) {
                                button +=
                                    '<button class="btn btn-outline-success btn-sm mr-1" data-toggle="tooltip" data-placement="bottom" title="Order shipped"><i class="fas fa-dolly"></i></button>';
                            }

                            if (full['deliverystatus'] == 0 && full['status'] == 1) {
                                button +=
                                    '<button class="btn btn-outline-danger btn-sm mr-1 btndelivery" data-toggle="tooltip" data-placement="bottom" title="Delivery not completed" id="' +
                                    full['idtbl_porder'] +
                                    '"><i class="fas fa-truck"></i></button>';
                            } else if (full['status'] == 1) {
                                button +=
                                    '<button class="btn btn-outline-success btn-sm mr-1" data-toggle="tooltip" data-placement="bottom" title="Delivery completed"><i class="fas fa-truck"></i></button>';
                            }

                            if (full['deliverystatus'] == 0 && full['status'] == 1) {
                                button +=
                                    '<button class="btn btn-outline-danger btn-sm mr-1 btncancel" data-toggle="tooltip" data-placement="bottom" title="Cancel order" id="' +
                                    full['idtbl_porder'] +
                                    '"><i class="fas fa-window-close"></i></button><button class="btn btn-primary btn-sm btnreturn" id="' +
                                    full['idtbl_porder'] +
                                    '"><i class="fas fa-redo-alt"></i></button>';
                            }


                            if (deletecheck != 0) {
                                button +=
                                    '<button class="btn btn-outline-danger btn-sm btnDelete ml-1 " id="' +
                                    full['idtbl_invoice'] +
                                    '"><i class="fas fa-trash"></i></button> ';
                            }
                        }


                        return button;
                    }
                }
            ]
        });

        $('#dataTable tbody').on('click', '.btnView', function () {
            var id = $(this).attr('id');

            $('#modalinvoicereceipt').modal('show');
            $('#viewreceiptprint').html(
                '<div class="card border-0 shadow-none bg-transparent"><div class="card-body text-center"><img src="images/spinner.gif" alt="" srcset=""></div></div>'
            );

            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: 'pdfprocess/invoicepdf.php',
                success: function (result) { //alert(result);
                    $('#iframeModal').attr('src', 'pdfprocess/invoicepdf.php');
                }
            });
        });

        $('#dataTable tbody').on('click', '.btnship', function() {
            var r = confirm("Are you sure, Ship this order ? ");
            if (r == true) {
                var id = $(this).attr('id');
                var type= '2';
                statuschange(id, type);
            }
        });
        $('#dataTable tbody').on('click', '.btndelivery', function() {
            var r = confirm("Are you sure, Delivery complete this order ? ");
            if (r == true) {
                var id = $(this).attr('id');
                var type= '3';
                statuschange(id, type);
            }
        });


        // $('#dataTable tbody').on('click', '.btnQty', function () {

        //     $('#hiddenid').val(id);
        //     var r = quantity_correct();
        //     if (r == true) {

        //         var status = $(this).attr('name');

        //         if (status == 0) {
        //             $('#modalquantitycheck').modal('show');
        //             $('#hiddenstatus').val("0");
        //         } else {
        //             $('#qtyreason').val("Quantity is correct");
        //             $('#hiddenstatus').val("1");
        //             document.getElementById("qtySubmitBtn").click();
        //         }
        //     }
        // });

        // $('#dataTable tbody').on('click', '.btnQty2', function () {
        //     var r = quantity_confirm();
        //     if (r == true) {
        //         var id = $(this).attr('id');
        //         var status = $(this).attr('name');
        //         $('#hiddenid').val(id);
        //         if (status == 0) {
        //             $('#modalquantitycheck').modal('show');
        //             $('#hiddenstatus').val("0");
        //         } else {
        //             $('#qtyreason').val("Quantity is correct");
        //             $('#hiddenstatus').val("1");
        //             document.getElementById("qtySubmitBtn").click();
        //         }
        //     }
        // });

        $('#dataTable tbody').on('click', '.btnCheck', function () {
            var id = $(this).attr('id');
            $('#hiddenid').val(id);
            $('#modalquantitycheck').modal('show');
            $('#hiddenstatus').val("0");

        });
        $('#dataTable tbody').on('click', '.btnDelete', function () {
            var id = $(this).attr('id');
            $('#record').val(id);
            $('#modalcancelreason').modal('show');
            $('#hiddenstatus').val("0");

        });

        document.getElementById('btnreceiptprint').addEventListener("click", print);
    });

    $('input[type="radio"]').change(function (e) {
        var value = $('input[name="qtycheckratio"]:checked').val()
        // alert(value)
        if (value == 1) {
            $('#hiddenqtydiv').addClass('d-none');
            $('#qtyreason').prop('required', false);

        } else {
            $('#hiddenqtydiv').removeClass('d-none');
            $('#qtyreason').prop('required', true);
        }
    });

    function statuschange(id, type){//alert(id);
        var cancelreason = '';
        $.ajax({
            type: "POST",
            data: {
                recordID: id,
                type: type,
                cancelreason: cancelreason
            },
            url: 'process/statuscusporder.php',
            success: function(result) { //alert(result);
                // action(result);
                $('#dataTable').DataTable().ajax.reload( null, false );
                // loaddatatable();
            }
        }); 
    }

    function print() {
        printJS({
            printable: 'viewreceiptprint',
            type: 'html',
            style: '@page { size: portrait; margin:0.25cm; }',
            targetStyles: ['*']
        })
    }

    function delete_confirm() {
        return confirm("Are you sure you want to remove this?");
    }

    function quantity_confirm() {
        return confirm("Are you sure the quantity is wrong?");
    }

    function quantity_correct() {
        return confirm("Are you sure the quantity is correct?");
    }

    function delivery_confirm() {
        return confirm("Are you sure that the delivery is completed?");
    }

    function delivery_not_confirm() {
        return confirm("Are you sure that the delivery is not completed?");
    }


    function deactive_confirm() {
        return confirm("Are you sure you want to deactive this?");
    }

    function active_confirm() {
        return confirm("Are you sure you want to active this?");
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
</script>
<?php include "include/footer.php"; ?>