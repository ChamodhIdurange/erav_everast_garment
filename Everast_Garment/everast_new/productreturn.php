<?php
include "include/header.php";

$sqlcustomer = "SELECT `idtbl_customer`, `name` FROM `tbl_customer` WHERE `status`=1 ORDER BY `name` ASC";
$resultcustomer = $conn->query($sqlcustomer);


$sqlproduct = "SELECT `idtbl_product`, `product_name` FROM `tbl_product` WHERE `status`=1";
$resultproduct = $conn->query($sqlproduct);

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
                        <div class="row">
                            <div class="col-12">
                                <form id="searchform">
                                    <div class="form-row">
                                        <div class="col-3">
                                            <label class="small font-weight-bold text-dark">Return type*</label>
                                            <select name="returntype" id="returntype"
                                                class="form-control form-control-sm rounded-0" required>
                                                <option value="">Select</option>
                                                <option value="1">Customer return</option>
                                                <!-- <option value="2">Supplier return</option> -->
                                                <option value="3">Damage return</option>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label class="small font-weight-bold text-dark">Customer*</label>
                                            <div class="input-group input-group-sm">
                                                <select class="form-control form-control-sm rounded-0" name="customer"
                                                    id="customer">
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <label class="small font-weight-bold text-dark">Customer Invoice*</label>
                                            <div class="input-group input-group-sm">
                                                <select class="form-control form-control-sm rounded-0"
                                                    name="customerinvoice" id="customerinvoice">
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">&nbsp;</div>
                                    </div>
                                    <input type="submit" class="d-none" id="hidesubmit">
                                </form>
                            </div>
                        </div>
                        <hr class="border-dark">
                        <div class="row">
                            <div class="col-12">
                                <form id="returnform" method="post" autocomplete="off">
                                    <div class="row">
                                        <div class="col-md-8" id="getinvotable">
                                            <!-- Content for getinvotable goes here -->
                                        </div>
                                        <div class="col-md-4" id="reasondiv">
                                            <label class="small font-weight-bold text-dark">Remarks</label>
                                            <textarea class="form-control form-control-sm" id="remarks"
                                                name="remarks"></textarea>
                                            <div class="form-group mt-3">
                                                <button type="button" id="formsubmit"
                                                    class="btn btn-outline-primary btn-sm px-4 fa-pull-right"
                                                    <?php if ($addcheck == 0) {echo 'disabled';} ?>>
                                                    <i class="far fa-save"></i>&nbsp;Add
                                                </button>
                                                <button class="d-none" id="submitBtn">Submit</button>
                                            </div>
                                            <input type="hidden" name="recordID" id="recordID" value="">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-striped table-bordered table-sm small" id="tablereturn">
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

                                        <input type="hidden" id="hidetotalorder" value="0">
                                        <input type="hidden" id="hidedis" value="0">
                                        <input type="hidden" id="hidenetamount" value="0">
                                    </div>
                                    <div class="form-group mt-2">
                                        <button type="button" id="btnCreateReturn"
                                            class="btn btn-outline-primary btn-sm fa-pull-right"
                                            <?php if ($addcheck == 0) {
                                                                                                                                                echo 'disabled';
                                                                                                                                            } ?>><i
                                                class="fas fa-save"></i>&nbsp;Create Return</button>
                                    </div>
                                    <input type="hidden" id="hidetotalorder2" value="">

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

        $("#customer").select2({
            ajax: {
                url: "getprocess/getcustomerlistforreturn.php",
                // url: "getprocess/getproductaccosupplier.php",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term, // search term
                    };
                },
                processResults: function (response) { //console.log(response)
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });

        $('#customer').change(function () {
            var customer = $(this).val();

            $.ajax({
                type: "POST",
                data: {
                    customerId: customer,
                },
                url: 'getprocess/getinvoicesaccocustomer.php',
                success: function (result) { //alert(result)
                    var objfirst = JSON.parse(result);
                    var html = '';
                    html += '<option value="">Select</option>';
                    $.each(objfirst, function (i, item) {
                        //alert(objfirst[i].id);
                        html += '<option value="' + objfirst[i].invoiceId + '">';
                        html += objfirst[i].invoiceId + ' - ' + objfirst[i]
                            .invoiceNo;
                        html += '</option>';
                    });
                    $('#customerinvoice').empty().append(html);
                }
            });
        });
        $('#customerinvoice').change(function () {
            var invoiceId = $(this).val();
            $('#tablereturn tbody').empty();

            $.ajax({
                type: "POST",
                data: {
                    invoiceId: invoiceId,
                },
                url: 'getprocess/returngettable.php',
                success: function (result) { //alert(result)
                    $('#getinvotable').empty();

                    $('#getinvotable').html(result)
                }
            });
        });
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

            var returntype = $('#returntype').val();
            var customer = $('#customer').val();
            var customerinvoice = $('#customerinvoice').val();
            var total = $('#hidetotalorder').val();
            var remarks = $('#remarks').val();
            var discountamount = $('#hidedis').val();
            var netamount = $('#hidenetamount').val();

            $.ajax({
                type: "POST",
                data: {
                    tableData: jsonObj,
                    returntype: returntype,
                    total: total,
                    remarks: remarks,
                    customer: customer,
                    customerinvoice: customerinvoice,
                    discountamount: discountamount,
                    netamount: netamount
                },
                url: 'process/returnprocess.php',
                success: function (result) {console.log(result)
                    location.reload();
                }
            });
        }
    });

    $('#returntype').change(function () {
        var type = $(this).val();

        if (type == 1) {
            $('#customerdiv').removeClass('d-none');
            $('#customer').prop('required', true);

            $('#supplierdiv').addClass('d-none');
            $('#supplier').prop('required', false);
            //  $('#reasondiv').addClass('d-none');
            $('#remarks').prop('required', false);
            $('#reasondiv').removeClass('d-none');
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
        var unitprice = $('option:selected', this).data("unitprice");
        $('#unitprice').val(unitprice);

        // $.ajax({
        //     type: "POST",
        //     data: {
        //         productID: productID
        //     },
        //     url: 'getprocess/getsalpriceaccoproduct.php',
        //     success: function (result) { //alert(result);
        //         var obj = JSON.parse(result);
        //         $('#unitprice').val(obj.saleprice);
        //         // $('#saleprice').val(obj.saleprice);
        //     }
        // });
    });

    $('#customer').change(function () {
        var customerId = $(this).val();
        $.ajax({
            type: "POST",
            data: {
                customerId: customerId,
                type: 2,
                invoiceId: '',
            },
            url: 'getprocess/getcustomerinvoiceproducts.php',
            success: function (result) { //alert(result);
                var objfirst = JSON.parse(result);
                var html1 = '';
                html1 += '<option value="">Select</option>';
                $.each(objfirst, function (i, item) {
                    html1 += '<option value="' + objfirst[i].invoiceid + '">';
                    html1 += objfirst[i].name;
                    html1 += '</option>';
                });

                $('#customerinvoice').empty().append(html1);
            }
        });
    });
    $('#customerinvoice').change(function () {
        var invoiceId = $(this).val();
        $.ajax({
            type: "POST",
            data: {
                customerId: '',
                type: 1,
                invoiceId: invoiceId,
            },
            url: 'getprocess/getcustomerinvoiceproducts.php',
            success: function (result) { //alert(result);
                var objfirst = JSON.parse(result);
                var html1 = '';
                html1 += '<option value="">Select</option>';
                $.each(objfirst, function (i, item) {
                    html1 += '<option value="' + objfirst[i].id + '" data-saleprice="' +
                        objfirst[i].saleprice + '" data-unitprice="' + objfirst[i]
                        .unitprice + '">';
                    html1 += objfirst[i].name;
                    html1 += '</option>';
                });

                $('#product').empty().append(html1);
            }
        });
    });

    $("#formsubmit").click(function () {
        $('#tablereturn > tbody').empty();
        if (!$("#returnform")[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            $("#submitBtn").click();
        } else {


            $('#tablereturnamount tbody tr').each(function () {
                // Get the text value of each of the first five columns individually
                var invoiceId = $(this).find('td:eq(0)').text();
                var productId = $(this).find('td:eq(1)').text();
                var invoiceDetailId = $(this).find('td:eq(2)').text();
                var productName = $(this).find('td:eq(3)').text();
                var saleprice = $(this).find('td:eq(4)').text();
                var qty = $(this).find('td:eq(5)').text();

                var inputValue = $(this).find('input[name="editqtyreturn"]').val();
                var salepricenoformat = parseFloat(saleprice.replace(/,/g, ''));

                var showtotalreturn = addCommas(parseFloat(inputValue * salepricenoformat).toFixed(2));

                if(inputValue!=0){
                    $('#tablereturn > tbody:last').append('<tr class="pointer"><td class="d-none">' +
                    productId +
                    '</td><td>' + productName + '</td><td>' + saleprice + '</td><td>' + inputValue +
                    '</td><td class = "">' +
                    0 + '</td><td class = "total d-none">' + salepricenoformat * inputValue +
                    '</td><td class = "text-right">' +
                    showtotalreturn + '</td><td class = "discount d-none">' +
                    0 + '</td><td class = "d-none">' +
                    0 + '</td><td class = "d-none">' +
                    invoiceDetailId + '</td><td class = "d-none">' +
                    salepricenoformat + '</td></tr>');
                }

              
            });

            $('#tablereturnamount tbody').empty();

            $('#product').val('');

            var sum = 0;
            $(".total").each(function () {
                sum += parseFloat($(this).text());
            });
            var showsum = addCommas(parseFloat(sum).toFixed(2));

            var sumdis = 0;
            $(".discount").each(function () {
                sumdis += parseFloat($(this).text());
            });
            var showsumdis = addCommas(parseFloat(sumdis).toFixed(2));
            var hidedis = parseFloat(sumdis);
            var nettotal = sum - sumdis;
            var nettotalshow = addCommas(nettotal.toFixed(2));

            $('#discountedprice').html('Rs.' + showsumdis);
            $('#divtotal').html('Rs.' + showsum);
            $('#divtotalview').html(nettotalshow);

            $('#hidetotalorder').val(sum);
            $('#hidedis').val(hidedis);
            $('#hidenetamount').val(nettotal);

        }
    });

    $('#tablereturn').on('click', 'tr', function () {
        var r = confirm("Are you sure, You want to remove this ? ");
        if (r == true) {
            $(this).closest('tr').remove();

            var sum = 0;
            $(".total").each(function () {
                sum += parseFloat($(this).text());
            });
            var showsum = addCommas(parseFloat(sum).toFixed(2));

            var sumdis = 0;
            $(".discount").each(function () {
                sumdis += parseFloat($(this).text());
            });
            var showsumdis = addCommas(parseFloat(sumdis).toFixed(2));
            var hidedis = parseFloat(sumdis);
            var nettotal = sum - sumdis;
            var nettotalshow = addCommas(nettotal.toFixed(2));
            // $('#divtotal').html(showsum);
            $('#discountedprice').html('Rs.' + showsumdis);
            $('#divtotal').html('Rs.' + showsum);
            $('#divtotalview').html(nettotalshow);

            $('#hidetotalorder').val(sum);
            $('#hidedis').val(hidedis);
            $('#hidenetamount').val(nettotal);
        }
    });


    function textremove(classname, row) {
        $('#tableorderview tbody').on('keyup', classname, function (e) {
            if (e.keyCode === 13) {
                $this = $(this);
                var val = $this.val();
                var td = $this.closest('td');
                td.empty().html(val).data('editing', false);

                var rowID = row.closest("td").parent()[0].rowIndex;
                var unitprice = parseFloat(row.closest("tr").find('td:eq(7)').text());
                var newqty = parseFloat(row.closest("tr").find('td:eq(2)').text());
                var totnew = newqty * unitprice;

                var showtotnew = addCommas(parseFloat(totnew).toFixed(2));
                // var total = parseFloat(totrefill+totnew).toFixed(2);
                // var showtotal = addCommas(total);

                $('#tablereturnamount').find('tr').eq(rowID).find('td:eq(6)').text(showtotnew);
                // $('#tableorderview').find('tr').eq(rowID).find('td:eq(11)').text(showtotal);

                tabletotal1();
            }
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