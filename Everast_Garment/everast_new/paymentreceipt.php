<?php 
include "include/header.php";  

$sql="SELECT * FROM `tbl_invoice_payment` WHERE `status`=1";
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
                            <span>Payment Receipt</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Receipt No</th>
                                            <th>Date</th>
                                            <th class="text-right">Payment</th>
                                            <th class="text-right">Balance</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    
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
<!-- Modal Payment Receipt -->
<div class="modal fade" id="modalpaymentreceipt" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="viewreceiptprint"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-sm fa-pull-right" id="btnreceiptprint"><i class="fas fa-print"></i>&nbsp;Print Receipt</button>
            </div>
        </div>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
    $(document).ready(function() {
        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

        $('#dataTable').DataTable( {
            "destroy": true,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: "scripts/paymentreceiptviewlist.php",
                type: "POST", // you can use GET
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_invoice_payment"
                },
                {
                    "targets": -1,
                    "className": '',
                    "data": null,
                    "render": function(data, type, full) {
                        return 'PR-'+full['idtbl_invoice_payment'];
                    }
                },
           
                {
                    "data": "date"
                },
               
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var payment=addCommas(parseFloat(full['payment']).toFixed(2));
                        return payment;
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var payment=addCommas(parseFloat(full['balance']).toFixed(2));
                        return payment;
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button+='<button class="btn btn-outline-dark btn-sm btnview mr-1" id="'+full['idtbl_invoice_payment']+'"><i class="fas fa-eye"></i></button>';
                        button+='<a href="process/statuspaymentreceipt.php?record='+full['idtbl_invoice_payment']+'&type=3" onclick="return delete_confirm()" target="_self" class="btn btn-outline-danger mr-1 btn-sm ';if(deletecheck==0){button+='d-none';}button+='"><i class="far fa-trash-alt"></i></a>';
                        
                        if(full['paymentcomplete']==0 && full['status']==1){
                            // button+='<button class="btn btn-outline-danger btn-sm mr-1 btnpayment" data-toggle="tooltip" data-placement="bottom" title="Payment not Completed" id="'+full['idtbl_invoice']+'"><i class="fas fa-money-bill-alt"></i></button>';
                        button+='<a href="process/changepaymentstatus.php?record='+full['idtbl_invoice']+'&method='+full['method']+'&type=3" onclick="return active_confirm()" target="_self" class="btn btn-outline-danger mr-1 btn-sm ';button+='"><i class="fas fa-money-bill-alt"></i></a>';

                            }
                        else if(full['status']==1){button+='<button class="btn btn-outline-success btn-sm mr-1 btnpaydone" data-toggle="tooltip" data-placement="bottom" title="Payment Completed" id="'+full['idtbl_invoice']+'"><i class="fas fa-money-bill-alt"></i></button>';}

                        // if(full['shipstatus']==0 && full['status']==1){button+='<button class="btn btn-outline-danger btn-sm mr-1 btnship" data-toggle="tooltip" data-placement="bottom" title="Order not ship" id="'+full['idtbl_porder']+'"><i class="fas fa-dolly"></i></button>';}
                        // else if(full['status']==1){button+='<button class="btn btn-outline-success btn-sm mr-1" data-toggle="tooltip" data-placement="bottom" title="Order shipped"><i class="fas fa-dolly"></i></button>';}

                        // if(full['deliverystatus']==0 && full['status']==1){button+='<button class="btn btn-outline-danger btn-sm mr-1 btndelivery" data-toggle="tooltip" data-placement="bottom" title="Delivery not completed" id="'+full['idtbl_porder']+'"><i class="fas fa-truck"></i></button>';}
                        // else if(full['status']==1){button+='<button class="btn btn-outline-success btn-sm mr-1" data-toggle="tooltip" data-placement="bottom" title="Delivery completed"><i class="fas fa-truck"></i></button>';}

                        // if(full['deliverystatus']==0 && full['status']==1){button+='<button class="btn btn-outline-danger btn-sm mr-1 btncancel" data-toggle="tooltip" data-placement="bottom" title="Cancel order" id="'+full['idtbl_porder']+'"><i class="fas fa-window-close"></i></button><button class="btn btn-primary btn-sm btnreturn" id="'+full['idtbl_porder']+'"><i class="fas fa-redo-alt"></i></button>';}
                        return button;
                    }
                }
            ]
        } );

        // $('#dataTable tbody').on('click', '.btnpayment', function() {
        //     var id = $(this).attr('id');
        
        //     alert(id)
        //     $.ajax({
        //         type: "POST",
        //         data: {
        //             recordID: id
        //         },
        //         url: 'process/changepaymentstatus.php',
        //         success: function(result) { alert(result);
        //             location.reload()
        //         }
        //     });
        // });
        $('#dataTable tbody').on('click', '.btnview', function() {
            var paymentinoiceID =$(this).attr('id');
            // alert(paymentinoiceID)
            $('#modalpaymentreceipt').modal('show');
            $('#viewreceiptprint').html('<div class="card border-0 shadow-none bg-transparent"><div class="card-body text-center"><img src="images/spinner.gif" alt="" srcset=""></div></div>');

            $.ajax({
                type: "POST",
                data: {
                    paymentinoiceID: paymentinoiceID
                },
                url: 'getprocess/getpaymentreceipt.php',
                success: function(result) { //alert(result);
                    $('#viewreceiptprint').html(result);
                }
            });
        });

        document.getElementById('btnreceiptprint').addEventListener ("click", print);
    });

    function print() {
        printJS({
            printable: 'viewreceiptprint',
            type: 'html',
            style: '@page { size: A5 portrait; margin:0.25cm; }',
            targetStyles: ['*']
        })
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

    function active_confirm() {
        return confirm("Are you sure you payment recived?");
    }
</script>
<?php include "include/footer.php"; ?>
