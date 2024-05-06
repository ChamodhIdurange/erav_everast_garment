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
                    <div class="card-body p-0 p-2">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true">+</a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="supplierreturn-tab" data-toggle="tab" href="#supplierreturn"
                                    role="tab" aria-controls="supplierreturn" aria-selected="false">Supplier Returns</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="customerreturn-tab" data-toggle="tab" href="#customerreturn"
                                    role="tab" aria-controls="customerreturn" aria-selected="false">Customer returns</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="damage-tab" data-toggle="tab" href="#damage" role="tab"
                                    aria-controls="damage" aria-selected="false">Damage returns</a>
                            </li>

                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="inputrow">
                                    <div class="row">
                                        <div class="col-3">
                                            <form action="process/returnprocess.php" method="post" autocomplete="off">
                                                <div class="form-group mb-1">
                                                    <label class="small font-weight-bold text-dark">Return type*</label>
                                                    <select name="returntype" id="returntype"
                                                        class="form-control form-control-sm" required>
                                                        <option value="">Select</option>
                                                        <option value="1">Customer return</option>
                                                        <option value="2">Supplier return</option>
                                                        <option value="3">Damage return</option>

                                                    </select>
                                                </div>
                                                <div id="supplierdiv" class="d-none form-group mb-1">
                                                    <label class="small font-weight-bold text-dark">Supplier*</label>
                                                    <select name="supplier" id="supplier"
                                                        class="form-control form-control-sm" required>
                                                        <option value="">Select</option>
                                                        <?php if($resultsupplier->num_rows > 0) {while ($rowcustomer = $resultsupplier-> fetch_assoc()) { ?>
                                                        <option value="<?php echo $rowcustomer['idtbl_supplier'] ?>">
                                                            <?php echo $rowcustomer['suppliername'] ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </div>
                                                <div id="customerdiv" class="d-none form-group mb-1">
                                                    <label class="small  font-weight-bold text-dark">Customer*</label>
                                                    <select name="customer" id="customer"
                                                        class="form-control form-control-sm" required>
                                                        <option value="">Select</option>
                                                        <?php if($resultcustomer->num_rows > 0) {while ($rowcustomer = $resultcustomer-> fetch_assoc()) { ?>
                                                        <option value="<?php echo $rowcustomer['idtbl_customer'] ?>">
                                                            <?php echo $rowcustomer['name'] ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <label class="small font-weight-bold text-dark">Product*</label>
                                                    <select name="product" id="product"
                                                        class="form-control form-control-sm" required>
                                                        <option value="">Select</option>
                                                        <?php if($resultproduct->num_rows > 0) {while ($rowproduct = $resultproduct-> fetch_assoc()) { ?>
                                                        <option value="<?php echo $rowproduct['idtbl_product'] ?>">
                                                            <?php echo $rowproduct['product_name'] ?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <label class="small font-weight-bold text-dark">Qty*</label>
                                                    <input type="text" class="form-control form-control-sm" name="qty"
                                                        id="qty" required>
                                                </div>
                                                <div class="form-group mt-3">
                                                    <button type="submit" id="submitBtn"
                                                        class="btn btn-outline-primary btn-sm px-4 fa-pull-right"
                                                        <?php if($addcheck==0){echo 'disabled';} ?>><i
                                                            class="far fa-save"></i>&nbsp;Add</button>
                                                </div>
                                                <input type="hidden" name="recordOption" id="recordOption" value="1">
                                                <input type="hidden" name="recordID" id="recordID" value="">
                                            </form>
                                        </div>
                                        <div class="col-9">
                                            <div class="scrollbar pb-3" id="style-2">
                                                <table class="table table-bordered table-striped table-sm nowrap"
                                                    id="dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Date</th>
                                                            <th>Product</th>
                                                            <th>Qty</th>
                                                            <th>Actions</th>

                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="supplierreturn" role="tabpanel"
                                aria-labelledby="supplierreturn-tab">
                                <div class="inputrow">

                                    <br>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="scrollbar pb-3" id="style-2">
                                                <table class="table table-bordered table-striped table-sm nowrap"
                                                    id="dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Return No </th>
                                                            <th>Supplier </th>
                                                            <th>Product</th>
                                                            <th>Quantity</th>
                                                            <th>Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if($resultreturnsupplier->num_rows > 0) {while ($row = $resultreturnsupplier-> fetch_assoc()) { ?>
                                                        <tr>
                                                            <td><?php echo $row['idtbl_return'] ?></td>
                                                            <td><?php echo $row['suppliername'] ?></td>
                                                            <td>
                                                                <?php echo $row['product_name'] ?></td>
                                                            <td><?php echo $row['qty'] ?></td>
                                                            <td><?php echo $row['returndate'] ?></td>
                                                        </tr>
                                                        <?php }} ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="customerreturn" role="tabpanel"
                                aria-labelledby="customerreturn-tab">
                                <div class="inputrow">

                                    <br>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="scrollbar pb-3" id="style-2">
                                                <table class="table table-bordered table-striped table-sm nowrap"
                                                    id="dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Return No </th>
                                                            <th>Supplier </th>
                                                            <th>Product</th>
                                                            <th>Quantity</th>
                                                            <th>Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if($resultreturncustomer->num_rows > 0) {while ($row = $resultreturncustomer-> fetch_assoc()) { ?>
                                                        <tr>
                                                            <td><?php echo $row['idtbl_return'] ?></td>
                                                            <td><?php echo $row['name'] ?></td>
                                                            <td>
                                                            <?php echo $row['product_name'] ?></td>
                                                            <td><?php echo $row['qty'] ?></td>
                                                            <td><?php echo $row['returndate'] ?></td>
                                                        </tr>
                                                        <?php }} ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="damage" role="tabpanel"
                                aria-labelledby="damage-tab">
                                <div class="inputrow">

                                    <br>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="scrollbar pb-3" id="style-2">
                                                <table class="table table-bordered table-striped table-sm nowrap"
                                                    id="dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Return No </th>
                                                            <th>Product</th>
                                                            <th>Quantity</th>
                                                            <th>Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if($resultreturndamage->num_rows > 0) {while ($row = $resultreturndamage-> fetch_assoc()) { ?>
                                                        <tr>
                                                            <td><?php echo $row['idtbl_return'] ?></td>
                                                            <td>
                                                            <?php echo $row['product_name'] ?></td>
                                                            <td><?php echo $row['qty'] ?></td>
                                                            <td><?php echo $row['returndate'] ?></td>
                                                        </tr>
                                                        <?php }} ?>
                                                    </tbody>
                                                </table>
                                            </div>
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

        $('#dataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: "scripts/returnlist.php",
                type: "POST", // you can use GET
            },
            "order": [
                [0, "desc"]
            ],
            "columns": [{
                    "data": "idtbl_return"
                },
                {
                    "data": "returndate"
                },
                {
                    "data": "product_name"
                },
                {
                    "data": "qty"
                },

                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function (data, type, full) {
                        var button = '';

                        button += '<a href="process/statusacceptreturn.php?record=' +
                            full['idtbl_return'] +
                            '&type=' + full['returntype'] +
                            '" onclick="return accept_confirm()" target="_self" class="btn btn-outline-orange btn-sm mr-1" data-toggle="tooltip" data-placement="bottom" title="Accept return"><i class="fas fa-sign-out-alt"></i></a><button class="btn btn-outline-primary btn-sm btnEdit mr-1 ';
                        if (editcheck == 0) {
                            button += 'd-none';
                        }
                        button += '" id="' + full['idtbl_return'] +
                            '"><i class="fas fa-pen"></i></button>';
                        if (full['status'] == 1) {
                            button += '<a href="process/statusreturn.php?record=' + full[
                                    'idtbl_return'] +
                                '&type=2" onclick="return deactive_confirm()" target="_self" class="btn btn-outline-success btn-sm mr-1 ';
                            if (statuscheck == 0) {
                                button += 'd-none';
                            }
                            button += '"><i class="fas fa-check"></i></a>';
                        } else {
                            button += '<a href="process/statusreturn.php?record=' + full[
                                    'idtbl_return'] +
                                '&type=1" onclick="return active_confirm()" target="_self" class="btn btn-outline-warning btn-sm mr-1 ';
                            if (statuscheck == 0) {
                                button += 'd-none';
                            }
                            button += '"><i class="fas fa-times"></i></a>';
                        }
                        button += '<a href="process/statusreturn.php?record=' + full[
                                'idtbl_return'] +
                            '&type=3" onclick="return delete_confirm()" target="_self" class="btn btn-outline-danger btn-sm ';
                        if (deletecheck == 0) {
                            button += 'd-none';
                        }
                        button += '"><i class="far fa-trash-alt"></i></a>';
                        return button;
                    }
                }
            ]
        });
        $('#dataTable tbody').on('click', '.btnEdit', function () {
            var r = confirm("Are you sure, You want to Edit this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: 'getprocess/getproductreturn.php',
                    success: function (result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);

                        if (obj.returntype == 1) {
                            $('#customer').val(obj.customer);
                            $('#supplier').val("");

                            $('#customerdiv').removeClass('d-none');
                            $('#customer').prop('required', true);
                            $('#supplierdiv').addClass('d-none');
                            $('#supplier').prop('required', false);

                        } else if (obj.returntype == 2) {
                            $('#supplier').val(obj.supplier);
                            $('#customer').val("");

                            $('#customerdiv').addClass('d-none');
                            $('#customer').prop('required', false);
                            $('#supplierdiv').removeClass('d-none');
                            $('#supplier').prop('required', true);
                        } else {
                            $('#supplier').val("");
                            $('#customer').val("");

                            $('#customerdiv').addClass('d-none');
                            $('#customer').prop('required', false);
                            $('#supplierdiv').addClass('d-none');
                            $('#supplier').prop('required', false);
                        }


                        $('#returntype').val(obj.returntype);
                        $('#product').val(obj.product);
                        $('#qty').val(obj.qty);

                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                    }
                });
            }
        });
    });

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