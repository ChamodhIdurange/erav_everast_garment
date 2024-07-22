<?php 
include "include/header.php";  

// $productarray=array();
// $sqlproduct="SELECT `idtbl_product`, `product_name` FROM `tbl_product` WHERE `status`=1";
// $resultproduct =$conn-> query($sqlproduct);

// $sqlmaterial="SELECT `idtbl_material`, `materialname` FROM `tbl_material` WHERE `status`=1";
// $resultmaterial =$conn-> query($sqlmaterial);

// $sqlproduct="SELECT `idtbl_product`, `product_name` FROM `tbl_product` WHERE `status`=1";
// $aresultproduct =$conn-> query($sqlproduct); 

// $sqlproductlist="SELECT `p`.`idtbl_product`, `p`.`product_name`, SUM(`pm`.`tbl_product_idtbl_product`) as 'productcount' FROM `tbl_product` AS `p` JOIN `tbl_product_materials` AS `pm` ON (`p`.`idtbl_product` = `pm`.`tbl_product_idtbl_product`) WHERE `pm`.`status`=1 GROUP BY `pm`.`tbl_product_idtbl_product`";
// $resultproductlist =$conn-> query($sqlproductlist);

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
                            <div class="page-header-icon"><i data-feather="shopping-cart"></i></div>
                            <span>Product Materials Not in use</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-outline-primary btn-sm fa-pull-right"
                                    id="btnAssemble"><i class="fas fa-plus"></i>&nbsp;Assemble
                                    Product</button>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-5">
                                <form id="productmaterialform" method="post" autocomplete="off">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Product*</label>
                                        <select class="form-control form-control-sm" name="product" id="product"
                                            required>
                                            <option value="">Select</option>
                                            <?php while ($rowproduct = $resultproduct-> fetch_assoc()){ ?>
                                            <option value="<?php echo $rowproduct['idtbl_product'] ?>">
                                                <?php echo $rowproduct['product_name']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-6  mb-1">
                                            <label class="small font-weight-bold text-dark">Material*</label>
                                            <select class="form-control form-control-sm" name="materials" id="materials"
                                                required>
                                                <option value="">Select</option>
                                                <?php while ($rowmaterial = $resultmaterial-> fetch_assoc()){ ?>
                                                <option value="<?php echo $rowmaterial['idtbl_material'] ?>">
                                                    <?php echo $rowmaterial['materialname']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-6  mb-1">
                                            <label class="small font-weight-bold text-dark">Required Qty*</label>
                                            <input type="text" id="requiredqty" name="requiredqty"
                                                class="form-control form-control-sm" required>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <button type="button" id="formsubmit"
                                            class="btn btn-outline-primary btn-sm w-50 fa-pull-right"
                                            <?php if($addcheck==0){echo 'disabled';} ?>><i
                                                class="fa fa-check"></i>&nbsp;Add</button>
                                        <button type="submit" id="btnsubmit" class="d-none">submit</button>
                                    </div>
                                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                                    <input type="hidden" name="recordID" id="recordID" value="">
                                </form>
                            </div>
                            <div class="col-7">
                                <table class="table table-bordered table-striped table-sm nowrap"
                                    id="tableproductmaterial">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Material</th>
                                            <th>Required Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <button type="button"
                                        class="btn btn-outline-primary btn-sm fa-pull-right px-5 <?php if($addcheck==0){echo 'disabled';} ?>"
                                        id="btnComplete"><i class="far fa-save"></i>&nbsp;Save</button>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <table class="table table-bordered table-striped table-sm nowrap" id="tablelist">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product</th>
                                            <!-- <th>Count</th> -->
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($resultproductlist->num_rows > 0) {while ($row = $resultproductlist-> fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $row['idtbl_product'] ?></td>
                                            <td><?php echo $row['product_name'] ?></td>
                                            <!-- <td><?php echo $row['productcount'] ?></td> -->
                                            <td class="text-right">
                                                <button class="btn btn-outline-dark btn-sm btnView"
                                                    id="<?php echo $row['idtbl_product'] ?>"><i
                                                        data-feather="eye"></i></button>
                                            </td>

                                        </tr>
                                        <?php }} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
    <!-- Modal Product details -->
    <div class="modal fade" id="modaproductmaterial" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="detailsbody"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Assemble Order -->
    <div class="modal fade" id="modalassemble" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
                            <form id="assembleorderform" autocomplete="off">
                                <div class="form-group mb-1">
                                    <label class="small font-weight-bold text-dark">Order Date*</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control dpd1a" placeholder="" name="aorderdate"
                                            id="aorderdate" required>
                                        <div class="input-group-append">
                                            <span class="btn btn-light border-gray-500"><i
                                                    class="far fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="small font-weight-bold text-dark">Product*</label>
                                    <select class="form-control form-control-sm" name="aproduct" id="aproduct" required>
                                        <option value="">Select</option>
                                        <?php if($aresultproduct->num_rows > 0) {while ($rowproduct = $aresultproduct-> fetch_assoc()) { ?>
                                        <option value="<?php echo $rowproduct['idtbl_product'] ?>">
                                            <?php echo $rowproduct['product_name'] ?></option>
                                        <?php }} ?>
                                    </select>
                                </div>
                                <div class="form-row mb-1">
                                    <div class="col">
                                        <label class="small font-weight-bold text-dark">Qty*</label>
                                        <input type="text" id="anewqty" name="anewqty"
                                            class="form-control form-control-sm" value="1" required>
                                    </div>
                                </div>
                                <input class='d-none' type="submit" id="assemblesubmit">

                            </form>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">
                            <table class="table table-striped table-bordered table-sm small" id="tableassemble">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Material</th>
                                        <th class="text-center">Qty</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                            <hr>
                            <div class="form-group">
                                <label class="small font-weight-bold text-dark">Remark</label>
                                <textarea name="aremark" id="aremark" class="form-control form-control-sm"></textarea>
                            </div>
                            <div class="form-group mt-2">
                                <button type="button" id="btnassembleorder"
                                    class="btn btn-outline-primary btn-sm fa-pull-right"
                                    <?php if($addcheck==0){echo 'disabled';} ?>><i
                                        class="fas fa-save"></i>&nbsp;Assemble</button>
                            </div>
                            <div class="form-group mt-3 text-danger small">
                                <span class="badge badge-danger mr-2">&nbsp;&nbsp;</span> Stock quantity warning
                            </div>
                            <div id="errordiv">

                            </div>

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
        // $('.dpd1a').datepicker({
        //     uiLibrary: 'bootstrap4',
        //     autoclose: 'true',
        //     todayHighlight: true,
        //     startDate: 'today',
        //     format: 'yyyy-mm-dd'
        // });
        // $('#tablelist').DataTable({});
    });
    // $("#formsubmit").click(function () {
    //     if (!$("#productmaterialform")[0].checkValidity()) {
    //         // If the form is invalid, submit it. The form won't actually submit;
    //         // this will just cause the browser to display the native HTML5 error messages.
    //         $("#btnsubmit").click();
    //     } else {
    //         var productID = $('#product').val();
    //         var product = $("#product option:selected").text();
    //         var materialId = $('#materials').val();
    //         var material = $("#materials option:selected").text();
    //         var requiredqty = $('#requiredqty').val();

    //         $('#tableproductmaterial > tbody:last').append('<tr class="pointer"><td class = "d-none">' +
    //             productID +
    //             '</td><td class="">' +
    //             materialId + '</td><td class="">' + material +
    //             '</td><td class="text-center">' + requiredqty + '</td></tr>');

    //         $('#materials').focus();
    //         $('#materials').val('')
    //         $('#requiredqty').val('')
    //     }
    // });

    // $('#btnAssemble').click(function () {
    //     $('#modalassemble').modal('show');
    //     $('#modalassemble').on('shown.bs.modal', function () {
    //         $('#orderdate').trigger('focus');
    //     })
    // });
    // $('#btnComplete').click(() => {
    //     var tbody = $("#tableproductmaterial tbody");
    //     if (tbody.children().length > 0) {
    //         jsonObj = [];
    //         $("#tableproductmaterial tbody tr").each(function () {
    //             item = {}
    //             $(this).find('td').each(function (col_idx) {
    //                 item["col_" + (col_idx + 1)] = $(this).text();
    //             });
    //             jsonObj.push(item);
    //         });
    //         console.log(jsonObj);

    //         var productID = $('#product').val();
    //         $.ajax({
    //             type: "POST",
    //             data: {
    //                 tableData: jsonObj,
    //                 productID: productID,
    //             },
    //             url: 'process/productmaterialprocess.php',
    //             success: function (result) {
    //                 action(result);
    //             }
    //         });

    //     }
    // })
    // $('#tablelist tbody').on('click', '.btnView', function () {
    //     let productid = $(this).attr('id')
    //     $.ajax({
    //         type: "POST",
    //         data: {
    //             recordID: productid
    //         },
    //         url: 'getprocess/getmaterialproductdetails.php',
    //         success: function (result) {
    //             $('#detailsbody').html(result)
    //             $('#modaproductmaterial').modal('show')

    //         }
    //     });
    // })

    // $('#btnassembleorder').click(function () { //alert('IN');
    //     if (!$("#assembleorderform")[0].checkValidity()) {
    //         // If the form is invalid, submit it. The form won't actually submit;
    //         // this will just cause the browser to display the native HTML5 error messages.
    //         $("#assemblesubmit").click();
    //     } else {
    //         var tbody = $("#tableassemble tbody");

    //         if (tbody.children().length > 0) {
    //             jsonObj = [];
    //             $("#tableassemble tbody tr").each(function () {
    //                 item = {}
    //                 $(this).find('td').each(function (col_idx) {
    //                     item["col_" + (col_idx + 1)] = $(this).text();
    //                 });
    //                 jsonObj.push(item);
    //             });
    //             // console.log(jsonObj);

    //             var orderdate = $('#aorderdate').val();
    //             var remark = $('#aremark').val();
    //             var productid = $('#aproduct').val();
    //             var qty = $('#anewqty').val();

    //             $.ajax({
    //                 type: "POST",
    //                 data: {
    //                     tableData: jsonObj,
    //                     orderdate: orderdate,
    //                     productid: productid,
    //                     qty: qty,
    //                     remark: remark
    //                 },
    //                 url: 'process/assembleorderprocess.php',
    //                 success: function (result) { //alert(result);
    //                     action(result);
    //                     location.reload();
    //                 }
    //             });
    //         }
    //     }

    // });

    // $('#aproduct').change(function () {
    //     var productID = $(this).val();
    //     $('#btnassembleorder').attr('disabled',false);

    //     $.ajax({
    //         type: "POST",
    //         data: {
    //             productID: productID
    //         },
    //         url: 'getprocess/getproductassembledetails.php',
    //         success: function (result) { //alert(result);
    //             $('#tableassemble > tbody').empty();
    //             var obj = JSON.parse(result);

    //             $.each(obj, function (i, item) {
    //                 $('#tableassemble > tbody:last').append('<tr><td>' +
    //                     obj[i].materialid +
    //                     '</td><td class="">' + obj[i].materialname +
    //                     '</td><td class="text-left reqqty">' + obj[i]
    //                     .requiredqty + '</td><td class="d-none staticqty">' + obj[i]
    //                     .requiredqty + '</td></tr>');

    //             });
    //         }
    //     });
    // });

    // function checkstock(materialid, requiredqty){
    //     $.ajax({
    //         type: "POST",
    //         data: {
    //             materialid: materialid,
    //             requiredqty: requiredqty,
    //         },
    //         url: 'getprocess/checkmaterialstock.php',
    //         success: function (result) { //alert(result);
    //             var obj = JSON.parse(result);
    //             if(!obj.qty){
    //                 $('#btnassembleorder').attr('disabled','disabled');

    //                 var error = ` <div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Warning!</strong> The material with id '${materialid}' don't have enough stock available<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>`
    //                 $('#errordiv').html(error)

    //             }
    //         }
    //     });
    // }

    // $('#anewqty').keyup(function () {
    //     var qty = $(this).val();
    //     let newqty = 0;
    //     let materialId;

    //     $(".staticqty").each(function () {
    //         var row = $(this);

    //         reqqty = parseFloat($(this).text());
    //         newqty = reqqty * qty;

    //         row.closest("tr").find('td:eq(2)').html(newqty)
    //         materialId = row.closest("tr").find('td:eq(0)').text()

    //         checkstock(materialId, newqty)
    //     });

    // });

    // function action(data) { //alert(data);
    //     var obj = JSON.parse(data);
    //     $.notify({
    //         // options
    //         icon: obj.icon,
    //         title: obj.title,
    //         message: obj.message,
    //         url: obj.url,
    //         target: obj.target
    //     }, {
    //         // settings
    //         element: 'body',
    //         position: null,
    //         type: obj.type,
    //         allow_dismiss: true,
    //         newest_on_top: false,
    //         showProgressbar: false,
    //         placement: {
    //             from: "top",
    //             align: "center"
    //         },
    //         offset: 100,
    //         spacing: 10,
    //         z_index: 1031,
    //         delay: 5000,
    //         timer: 1000,
    //         url_target: '_blank',
    //         mouse_over: null,
    //         animate: {
    //             enter: 'animated fadeInDown',
    //             exit: 'animated fadeOutUp'
    //         },
    //         onShow: null,
    //         onShown: null,
    //         onClose: null,
    //         onClosed: null,
    //         icon_type: 'class',
    //         template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
    //             '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
    //             '<span data-notify="icon"></span> ' +
    //             '<span data-notify="title">{1}</span> ' +
    //             '<span data-notify="message">{2}</span>' +
    //             '<div class="progress" data-notify="progressbar">' +
    //             '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
    //             '</div>' +
    //             '<a href="{3}" target="{4}" data-notify="url"></a>' +
    //             '</div>'
    //     });
    //     location.reload();
    // }
</script>
<?php include "include/footer.php"; ?>




