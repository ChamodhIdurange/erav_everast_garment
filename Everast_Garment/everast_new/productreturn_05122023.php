<?php 
include "include/header.php";  

$sqlcustomer="SELECT `idtbl_customer`, `name` FROM `tbl_customer` WHERE `status`=1 ORDER BY `name` ASC";
$resultcustomer =$conn-> query($sqlcustomer);

$sqlsupplier="SELECT `idtbl_supplier`, `suppliername` FROM `tbl_supplier` WHERE `status`=1 ORDER BY `suppliername` ASC";
$resultsupplier =$conn-> query($sqlsupplier);

$sqlproduct="SELECT `idtbl_product`, `product_name` FROM `tbl_product` WHERE `status`=1";
$resultproduct =$conn-> query($sqlproduct);

$sqlreturnsupplier="SELECT `u`.`qty`,`u`.`idtbl_return`, `u`.`returndate`, `us`.`suppliername`, `ub`.`product_name`  FROM `tbl_return` AS `u` LEFT JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`) LEFT JOIN `tbl_supplier` AS `us` ON (`us`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) LEFT JOIN `tbl_product` AS `ub` ON (`ub`.`idtbl_product` = `u`.`tbl_product_idtbl_product`) WHERE `u`.`acceptance_status` = '1' and `u`.`returntype` = '2'";
$resultreturnsupplier =$conn-> query($sqlreturnsupplier);

$sqlreturncustomer="SELECT `u`.`qty`,`u`.`idtbl_return`, `u`.`returndate`, `ua`.`name`, `ub`.`product_name` FROM `tbl_return` AS `u` LEFT JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`) LEFT JOIN `tbl_supplier` AS `us` ON (`us`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) LEFT JOIN `tbl_product` AS `ub` ON (`ub`.`idtbl_product` = `u`.`tbl_product_idtbl_product`) WHERE `u`.`acceptance_status` = '1' and `u`.`returntype` = '1'";
$resultreturncustomer =$conn-> query($sqlreturncustomer);

$sqlreturndamage="SELECT `u`.`qty`,`u`.`idtbl_return`, `u`.`returndate`, `ua`.`name`, `ub`.`product_name` FROM `tbl_return` AS `u` LEFT JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`) LEFT JOIN `tbl_supplier` AS `us` ON (`us`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) LEFT JOIN `tbl_product` AS `ub` ON (`ub`.`idtbl_product` = `u`.`tbl_product_idtbl_product`) WHERE `u`.`acceptance_status` = '1' and `u`.`returntype` = '3'";
$resultreturndamage =$conn-> query($sqlreturndamage);

$sqlasm="SELECT `e`.`idtbl_employee`, `e`.`name` FROM `tbl_employee` AS `e`  WHERE `e`.`status`=1 AND `e`.`tbl_user_type_idtbl_user_type` in ('8')";
$resultasm=$conn->query($sqlasm);



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
                            <span>Product Return</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body">
                        <form id="returnform" method="post" autocomplete="off">

                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">ASM*</label>
                                        <select name="asm" id="asm" class="form-control form-control-sm"
                                            required>
                                            <option value="">Select</option>
                                            <?php if($resultasm->num_rows > 0) {while ($rowasm = $resultasm-> fetch_assoc()) { ?>
                                            <option value="<?php echo $rowasm['idtbl_employee'] ?>">
                                                <?php echo $rowasm['name'] ?></option>
                                            <?php }} ?>

                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Return type*</label>
                                        <select name="returntype" id="returntype" class="form-control form-control-sm"
                                            required>
                                            <option value="">Select</option>
                                            <option value="1">Customer return</option>
                                            <option value="2">Supplier return</option>
                                            <option value="3">Damage return</option>

                                        </select>
                                    </div>
                                    <div id="supplierdiv" class="d-none form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Supplier*</label>
                                        <select name="supplier" id="supplier" class="form-control form-control-sm"
                                            required>
                                            <option value="">Select</option>
                                            <?php if($resultsupplier->num_rows > 0) {while ($rowcustomer = $resultsupplier-> fetch_assoc()) { ?>
                                            <option value="<?php echo $rowcustomer['idtbl_supplier'] ?>">
                                                <?php echo $rowcustomer['suppliername'] ?></option>
                                            <?php }} ?>
                                        </select>
                                    </div>
                                    <div id="customerdiv" class="d-none form-group mb-1">
                                        <label class="small  font-weight-bold text-dark">Customer*</label>
                                        <select name="customer" id="customer" class="form-control form-control-sm"
                                            required>
                                            <option value="">Select</option>
                                            <?php if($resultcustomer->num_rows > 0) {while ($rowcustomer = $resultcustomer-> fetch_assoc()) { ?>
                                            <option value="<?php echo $rowcustomer['idtbl_customer'] ?>">
                                                <?php echo $rowcustomer['name'] ?></option>
                                            <?php }} ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Product*</label>
                                        <select name="product" id="product" class="form-control form-control-sm"
                                            required>
                                            <option value="">Select</option>
                                            <?php if($resultproduct->num_rows > 0) {while ($rowproduct = $resultproduct-> fetch_assoc()) { ?>
                                            <option value="<?php echo $rowproduct['idtbl_product'] ?>">
                                                <?php echo $rowproduct['product_name'] ?></option>
                                            <?php }} ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Sale Price*</label>
                                        <input type="text" class="form-control form-control-sm" name="unitprice"
                                            id="unitprice" required>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Qty*</label>
                                        <input type="text" class="form-control form-control-sm" name="qty" id="qty"
                                            required>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Discount(%)*</label>
                                        <input type="text" class="form-control form-control-sm" name="discount"
                                            id="discount" value="25" required>
                                    </div>
                                    <div id="reasondiv" class="form-group mb-1 d-none">
                                        <label class="small font-weight-bold text-dark">Remarks</label>
                                        <textarea class="form-control form-control-sm" id="remarks"
                                            name="remarks"></textarea>
                                    </div>
                                    <div class="form-group mt-3">
                                        <button type="button" id="formsubmit"
                                            class="btn btn-outline-primary btn-sm px-4  fa-pull-right"
                                            <?php if($addcheck==0){echo 'disabled';} ?>><i
                                                class="far fa-save"></i>&nbsp;Add</button>
                                        <button class="d-none" id="submitBtn">Submit</button>
                                    </div>
                                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                                    <input type="hidden" name="recordID" id="recordID" value="">
                                </div>

                                <div class="col-8">
                                    <div class="scrollbar pb-3" id="style-2">
                                        <table class="table table-striped table-bordered table-sm small"
                                            id="tablereturn">
                                            <thead>
                                                <tr>
                                                    <th class="d-none">ProductID</th>
                                                    <th>Product</th>
                                                    <th>Sale price</th>
                                                    <th>Quantity</th>
                                                    <th>Discount</th>
                                                    <th class="d-none">total</th>
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
                                                <h5 class="font-weight-600" id="divtotal">Rs. 0.00</h5>
                                            </div>
                                            <div class="col-9 text-right">
                                                <h5 class="font-weight-600">Discount</h5>
                                            </div>
                                            <div class="col-3 text-right">
                                                <h5 class="font-weight-600" id="discountedprice">Rs. 0.00</h5>
                                            </div>
                                            <div class="col-9 text-right">
                                                <h1 class="font-weight-600">Nettotal</h1>
                                            </div>
                                            <div class="col-3 text-right">
                                                <h1 class="font-weight-600" id="divtotalview">Rs. 0.00</h1>
                                            </div>

                                            <!-- <div class="col text-right">
                                                <h1 class="font-weight-600" id="divtotal">Rs. 0.00</h1>
                                            </div>
                                            <div class="col text-right">
                                                <h1 class="font-weight-600" id="divFulltotal">Rs. 0.00</h1>
                                            </div><br>
                                            <div class="col text-right">
                                                <h1 class="font-weight-600" id="discounted price">Rs. 0.00</h1>
                                            </div> -->

                                            <input type="hidden" id="hidetotalorder" value="0">
                                        </div>
                                        <div class="form-group mt-2">
                                            <button type="button" id="btnCreateReturn"
                                                class="btn btn-outline-primary btn-sm fa-pull-right"
                                                <?php if($addcheck==0){echo 'disabled';} ?>><i
                                                    class="fas fa-save"></i>&nbsp;Create Return</button>
                                        </div>
                                        <input type="hidden" id="hidetotalorder2" value="">

                                    </div>
                                </div>
                            </div>
                        </form>

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

        $('body').tooltip({
            selector: '[data-toggle="tooltip"]'
        });
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'hover'
        });
    });

    $("#formsubmit").click(function () {
        if (!$("#returnform")[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            $("#submitBtn").click();
        } else {


            var returntype = $('#returntype').val();
            var productID = $('#product').val();
            var product = $("#product option:selected").text();


            // var supplierID = $('#supplier').val();
            // var supplier = $("#supplier option:selected").text();
            var customerID = $('#customer').val();
            var customer = $("#customer option:selected").text();


            var unitprice = parseFloat($('#unitprice').val());
            var qty = parseFloat($('#qty').val());

            var discount = parseFloat($('#discount').val());

            var newtotal = parseFloat(unitprice * qty);

            var total = parseFloat(newtotal);
            var showtotal = "Rs." + total + ".00"





            $('#tablereturn > tbody:last').append('<tr class="pointer"><td class="d-none">' + productID +
                '</td><td>' + product + '</td><td>' + unitprice + '</td><td>' + qty +
                '</td><td class = "productdiscount">' +
                discount + '</td><td class = "total d-none">' + total + '</td><td class = "text-right">' +
                showtotal + '</td></tr>');


            $('#product').val('');
            $('#unitprice').val('');
            $('#qty').val('');
            $('#discount').val('25');

            var sum = 0;
            var sum2 = 0;
            var discount = 0;
            var totdiscount = 0;
            var c = 0;

            $("#tablereturn tr").each(function () {
                var unitprice = 0;
                var discountpercentage = 0;
                if (c == 0) {
                    c = 1;
                } else {
                    sum2 = $(this).closest("tr").find('td:eq(5)').html();
                    unitprice = parseFloat($(this).closest("tr").find('td:eq(5)').html());
                    discountpercentage = parseFloat($(this).closest("tr").find('td:eq(4)').html());
                    qty = parseFloat($(this).closest("tr").find('td:eq(3)').html());
                    // console.log(sum2)

                    // alert(discount);

                    sum += parseFloat(sum2);
                    discount = sum * discountpercentage / 100;
                    totdiscount += parseFloat(discount);
                }

            });


            var nettotal = sum - totdiscount;
            var showsum = "Rs." + sum + ".00"
            var showtotdiscount = "Rs." + totdiscount + ".00"
            var shownettotal = "Rs." + nettotal + ".00"
            $('#divtotal').html(showsum);
            $('#discountedprice').html(showtotdiscount);
            $('#divtotalview').html(shownettotal);

            $('#hidetotalorder').val(nettotal);



        }
    });

    $('#btnCreateReturn').click(function () { //alert('IN');
        var tbody = $("#tablereturn tbody");

        if (tbody.children().length > 0) {
            jsonObj = [];
            $("#tablereturn tbody tr").each(function () {
                item = {}
                $(this).find('td').each(function (col_idx) {
                    item["col_" + (col_idx + 1)] = $(this).text();
                });
                jsonObj.push(item);
            });
            // console.log(jsonObj);

            var returntype = $('#returntype').val();
            var customer = $('#customer').val();
            var supplier = $('#supplier').val();
            var total = $('#hidetotalorder').val();
            var recordOption = $('#recordOption').val();
            var remarks = $('#remarks').val();
            var asm = $('#asm').val();


            $.ajax({
                type: "POST",
                data: {
                    tableData: jsonObj,
                    returntype: returntype,
                    total: total,
                    recordOption: recordOption,
                    supplier: supplier,
                    asm: asm,
                    customer: customer
                },
                url: 'process/returnprocess.php',
                success: function (result) {
                    // alert(result);

                    location.reload();
                }
            });
        }
    });

    $('#tablereturn').on('click', 'tr', function () {
        var r = confirm("Are you sure, You want to remove this product ? ");
        if (r == true) {
            $(this).closest('tr').remove();

            var sum = 0;
            $(".total").each(function () {
                sum += parseFloat($(this).text());
            });

            var showsum = "Rs." + sum + ".00"
            $('#divtotal').html('Rs. ' + showsum);
            $('#hidetotalorder').val(sum);

        }
    });

    $('#returntype').change(function () {
        var type = $(this).val();

        if (type == 1) {
            $('#customerdiv').removeClass('d-none');
            $('#customer').prop('required', true);

            $('#supplierdiv').addClass('d-none');
            $('#supplier').prop('required', false);
            $('#reasondiv').addClass('d-none');
            $('#remarks').prop('required', false);
        } else if (type == 2) {
            $('#customerdiv').addClass('d-none');
            $('#customer').prop('required', false);

            $('#supplierdiv').removeClass('d-none');
            $('#supplier').prop('required', true);
            $('#reasondiv').addClass('d-none');
            $('#remarks').prop('required', false);
        } else {
            $('#customerdiv').removeClass('d-none');
            $('#customer').prop('required', true);
            $('#supplierdiv').addClass('d-none');
            $('#supplier').prop('required', false);
            $('#reasondiv').removeClass('d-none');
            $('#remarks').prop('required', true);
        }
    });
    $('#product').change(function () {
        var productID = $(this).val();

        $.ajax({
            type: "POST",
            data: {
                productID: productID
            },
            url: 'getprocess/getsalpriceaccoproduct.php',
            success: function (result) { //alert(result);
                var obj = JSON.parse(result);
                $('#unitprice').val(obj.saleprice);
                // $('#saleprice').val(obj.saleprice);
            }
        });
    });

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