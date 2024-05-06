<?php 
include "include/header.php";  

$sql="SELECT * FROM `tbl_product` WHERE `status` IN (1,2)";
$result =$conn-> query($sql); 

$sqlcategory="SELECT `idtbl_product_category`, `category` FROM `tbl_product_category` WHERE `status`=1";
$resultcategory=$conn->query($sqlcategory);

$sqlsupplier="SELECT `idtbl_supplier`, `suppliername` FROM `tbl_supplier` WHERE `status`=1";
$resultsupplier=$conn->query($sqlsupplier);

$sqlsizescategories="SELECT `idtbl_size_categories`, `name` FROM `tbl_size_categories` WHERE `status`=1";
$resultsizecategories=$conn->query($sqlsizescategories);

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
                            <span>Product</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                                <form action="process/productprocess.php" method="post" autocomplete="off"  enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form mb-1">

                                                <label class="small font-weight-bold text-dark">Supplier Name*</label>
                                                <select class="form-control form-control-sm" name="supplier"
                                                    id="supplier" required>
                                                    <option value="">Select</option>
                                                    <?php if($resultsupplier->num_rows > 0) {while ($rowcategory = $resultsupplier-> fetch_assoc()) { ?>
                                                    <option value="<?php echo $rowcategory['idtbl_supplier'] ?>">
                                                        <?php echo $rowcategory['suppliername'] ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-1">
                                                <label class="small font-weight-bold text-dark">Product*</label>
                                                <input id="productName" type="text" name="productName"
                                                    class="form-control form-control-sm" placeholder="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-1">
                                                <label class="small font-weight-bold text-dark">Common Name*</label>
                                                <input id="commonname" type="text" name="commonname"
                                                    class="form-control form-control-sm" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-1">
                                                <label class="small font-weight-bold text-dark">Product Code</label>
                                                <input id="productcode" type="text" name="productcode"
                                                    class="form-control form-control-sm" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4 d-none">
                                            <div class="form-group mb-1">
                                                <label class="small font-weight-bold text-dark">Bar Code</label>
                                                <input id="barcode" type="text" name="barcode"
                                                    class="form-control form-control-sm" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form mb-1">
                                                <label class="small font-weight-bold text-dark">Size Category*</label>
                                                <select class="form-control form-control-sm" name="sizecategory" id="sizecategory"
                                                    required>
                                                    <option value="">Select</option>
                                                    <?php if($resultsizecategories->num_rows > 0) {while ($rowsizes = $resultsizecategories-> fetch_assoc()) { ?>
                                                    <option value="<?php echo $rowsizes['idtbl_size_categories'] ?>">
                                                        <?php echo $rowsizes['name'] ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form mb-1">
                                                <label class="small font-weight-bold text-dark">Size*</label>
                                                <select class="form-control form-control-sm" name="size" id="size"
                                                    required>
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-1">
                                                <label class="small font-weight-bold text-dark">Cost Price</label>
                                                <input id="unitprice" type="text" name="unitprice"
                                                    class="form-control form-control-sm" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-1">
                                                <label class="small font-weight-bold text-dark">Retail Price</label>
                                                <input id="saleprice" type="text" name="saleprice"
                                                    class="form-control form-control-sm" placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group mb-1">

                                                <label class="small font-weight-bold text-dark">Main Category*</label>
                                                <select class="form-control form-control-sm" name="category"
                                                    id="category" required>
                                                    <option value="">Select</option>
                                                    <?php if($resultcategory->num_rows > 0) {while ($rowcategory = $resultcategory-> fetch_assoc()) { ?>
                                                    <option
                                                        value="<?php echo $rowcategory['idtbl_product_category'] ?>">
                                                        <?php echo $rowcategory['category'] ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-1">

                                                <label class="small font-weight-bold text-dark">Sub Category*</label>
                                                <select class="form-control form-control-sm" name="subcategory"
                                                    id="subcategory" required>
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-1">

                                                <label class="small font-weight-bold text-dark">Group Category*</label>
                                                <select class="form-control form-control-sm" name="groupcategory"
                                                    id="groupcategory" required>
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">

                                            <div class="form-group mb-1">
                                                <label class="small font-weight-bold text-dark">Re-Order Level</label>
                                                <input id="rol" type="text" name="rol"
                                                    class="form-control form-control-sm" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4 d-none">
                                            <label class="small font-weight-bold text-dark">Pieces for box</label>
                                            <input id="peices" type="text" name="peices"
                                                class="form-control form-control-sm" placeholder="">
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-1">
                                                <label class="small font-weight-bold text-dark">Uom</label>
                                                <select class="form-control form-control-sm" name="uom"
                                                    id="uom" required>
                                                    <option value="">Select</option>
                                                    <option value="1">PCS</option>
                                                    <option value="2">Packet</option>
                                                    <option value="3">Box</option>
                                                    <option value="4">Dozen</option>
                                                    <option value="5">Kilogram</option>
                                                    <option value="6">Bottle</option>
                                                    <option value="7">Roll</option>
                                                    <option value="8">Tin</option>
                                                    <option value="79">Berall</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-1">
                                                <label class="small font-weight-bold text-dark">Whole Sale Price</label>
                                                <input id="retail" type="text" name="retail"
                                                    class="form-control form-control-sm" placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-md-4 d-none">
                                            <div class="form-group mb-1">
                                                <label class="small font-weight-bold text-dark">Sale Discount(%)</label>
                                                <input id="salediscount" type="number" name="salediscount"
                                                    class="form-control form-control-sm" max="100" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4 d-none">
                                            <div class="form-group mb-1">
                                                <label class="small font-weight-bold text-dark">Retail
                                                    Discount(%)</label>
                                                <input id="retaildiscount" type="number" name="retaildiscount"
                                                    class="form-control form-control-sm" max="100" placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-md-4 d-none">
                                            <div class="form-group mb-1">
                                                <label class="small font-weight-bold text-dark">Star points</label>
                                                <input id="starpoints" type="text" name="starpoints"
                                                    class="form-control form-control-sm" max="100" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="small font-weight-bold text-dark">Product Image</label>
                                            <input type="file" name="productimage" id="productimage"
                                                class="form-control form-control-sm" style="padding-bottom:32px;">
                                            <small id="" class="form-text text-danger">Image size 800X800 Pixel</small>
                                        </div>

                                    </div>
                                    <div className="row">
                                        <div class="col-md-4">
                                            <div id="discountdiv" class="d-none form-group mb-1">
                                                <label class="small font-weight-bold text-dark">Discounst*</label>
                                                <input type="number" max="100" class=" form-control form-control-sm"
                                                    name="additionaldiscount" id="additionaldiscount">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-3">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" name="discountradio"
                                                    id="discountradio" value="4">
                                                <label class="custom-control-label" for="discountradio">
                                                    Additional Discount
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check ">
                                                <input class="form-check-input" type="radio" name="priceradio"
                                                    id="priceradio1" value="1" required>
                                                <label class="form-check-label" for="crmratio">
                                                    Unit price acceptable
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check ">
                                                <input class="form-check-input" type="radio" name="priceradio"
                                                    id="priceradio2" value="2" required>
                                                <label class="form-check-label" for="crmratio">
                                                    Precentage acceptable
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <button type="submit" id="submitBtn"
                                            class="btn btn-outline-primary btn-sm px-4  col-md-2 fa-pull-right"
                                            <?php if($addcheck==0){echo 'disabled';} ?>><i
                                                class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                                    <input type="hidden" name="recordID" id="recordID" value="">

                                </form>

                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>Code</th>
                                                <th>Category</th>
                                                <th>Retail Price</th>
                                                <th>Whole Sale Price</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($result->num_rows > 0) {while ($row = $result-> fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $row['idtbl_product'] ?></td>
                                                <td><?php echo $row['product_name'] ?></td>
                                                <td><?php echo $row['product_code'] ?></td>
                                                <td><?php $typeID=$row['tbl_product_category_idtbl_product_category']; $sqltype="SELECT `category` FROM `tbl_product_category` WHERE `idtbl_product_category`='$typeID'"; $resulttype =$conn-> query($sqltype); $rowtype = $resulttype-> fetch_assoc(); echo $rowtype['category']; ?>
                                                </td>
                                                <td><?php echo number_format($row['saleprice'], 2) ?></td>
                                                <td><?php echo number_format($row['retail'], 2) ?></td>
                                                <td class="text-right">
                                                    <button
                                                        class="btn btn-outline-primary btn-sm btnEdit <?php if($editcheck==0){echo 'd-none';} ?>"
                                                        id="<?php echo $row['idtbl_product'] ?>"><i
                                                            data-feather="edit-2"></i></button>
                                                    <?php if($row['status']==1){ ?>
                                                    <a href="process/statusproduct.php?record=<?php echo $row['idtbl_product'] ?>&type=2"
                                                        onclick="return confirm('Are you sure you want to deactive this?');"
                                                        target="_self"
                                                        class="btn btn-outline-success btn-sm <?php if($statuscheck==0){echo 'd-none';} ?>"><i
                                                            data-feather="check"></i></a>
                                                    <?php }else{ ?>
                                                    <a href="process/statusproduct.php?record=<?php echo $row['idtbl_product'] ?>&type=1"
                                                        onclick="return confirm('Are you sure you want to active this?');"
                                                        target="_self"
                                                        class="btn btn-outline-warning btn-sm <?php if($statuscheck==0){echo 'd-none';} ?>"><i
                                                            data-feather="x-square"></i></a>
                                                    <?php } ?>
                                                    <a href="process/statusproduct.php?record=<?php echo $row['idtbl_product'] ?>&type=3"
                                                        onclick="return confirm('Are you sure you want to remove this?');"
                                                        target="_self"
                                                        class="btn btn-outline-danger btn-sm <?php if($deletecheck==0){echo 'd-none';} ?>"><i
                                                            data-feather="trash-2"></i></a>
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
            </div>
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            dom: 'Blfrtip',
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "destroy": true,
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
                    url: 'getprocess/getproduct.php',
                    success: function (result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#productName').val(obj.product_name);
                        $('#productcode').val(obj.productcode);
                        $('#unitprice').val(obj.unitprice);
                        $('#saleprice').val(obj.saleprice);

                        $('#barcode').val(obj.barcode);
                        $('#rol').val(obj.rol);
                        $('#peices').val(obj.pices_per_box);
                        $('#retail').val(obj.retail);
                        $('#starpoints').val(obj.starpoints);
                        $('#category').val(obj.category);
                        $('#supplier').val(obj.supplier);
                        $('#retaildiscount').val(obj.retaildiscount);
                        $('#salediscount').val(obj.salediscount);
                        $('#commonname').val(obj.commonname);
                        $('#size').val(obj.size);
                        $('#sizecategory').val(obj.sizecategory);
                        $('#uom').val(obj.uom);

                        $('#productimage').prop('required', false);

                        loadsizecategory(obj.sizecategory, obj.size);
                        loadsubcategory(obj.category, obj.subcategory);
                        loadgroupcategory(obj.category, obj.groupcategory);
                        // alert(obj.radioprice)
                        if (obj.radioprice == 1) {
                            $("#priceradio1").prop("checked", true);
                            $("#priceradio2").prop("checked", false);
                        } else if (obj.radioprice == 2) {
                            $("#priceradio1").prop("checked", false);
                            $("#priceradio2").prop("checked", true);
                        }

                        if (obj.additionaldiscount == 0) {
                            $('#additionaldiscount').val(0);
                            $('#discountdiv').addClass('d-none');
                            $('#additionaldiscount').prop('required', false);
                            $('#discountradio').prop('checked', false);
                        } else {
                            $('#additionaldiscount').val(obj.additionaldiscount);
                            $('#discountdiv').removeClass('d-none');
                            $('#additionaldiscount').prop('required', true);
                            $('#discountradio').prop('checked', true);
                        }
                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                    }
                });
            }
        });
    });
    $('input[type="checkbox"]').change(function (e) {


        var value = $('input[name="discountradio"]:checked')

        if ($(this).prop("checked") == true) {
            $('#discountdiv').removeClass('d-none');
            $('#additionaldiscount').prop('required', true);

        } else {
            $('#discountdiv').addClass('d-none');
            $('#additionaldiscount').prop('required', false);
            $('#additionaldiscount').val(0);
        }

    });

    $('#category').change(function () {

        var categoryID = $('#category option:selected').val();
        var value = '';
        var value1 = '';

        loadsubcategory(categoryID, value);
        loadgroupcategory(categoryID, value1);
    })

    $('#sizecategory').change(function () {

        var sizecategoryID = $('#sizecategory option:selected').val();
        var value = '';

        loadsizecategory(sizecategoryID, value);
    })

    function loadsizecategory(sizecategoryID, value) {
        $.ajax({
            type: "POST",
            data: {
                sizecategoryID: sizecategoryID
            },
            url: 'getprocess/getsizesaccocategory.php',
            success: function (result) { // alert(result);
                var objfirst = JSON.parse(result);
                var html1 = '';
                html1 += '<option value="">Select</option>';
                $.each(objfirst, function (i, item) {
                    // alert(objfirst[i].id);
                    html1 += '<option value="' + objfirst[i].id + '">';
                    html1 += objfirst[i].name;
                    html1 += '</option>';
                });

                $('#size').empty().append(html1);

                if (value != '') {
                    $('#size').val(value);
                }
            }
        });
    }
    function loadsubcategory(categoryID, value) {
        $.ajax({
            type: "POST",
            data: {
                categoryID: categoryID
            },
            url: 'getprocess/getsubcategorylist.php',
            success: function (result) { // alert(result);
                var objfirst = JSON.parse(result);
                var html1 = '';
                html1 += '<option value="">Select</option>';
                $.each(objfirst, function (i, item) {
                    // alert(objfirst[i].id);
                    html1 += '<option value="' + objfirst[i].subid + '">';
                    html1 += objfirst[i].subname;
                    html1 += '</option>';
                });

                $('#subcategory').empty().append(html1);

                if (value != '') {
                    $('#subcategory').val(value);
                }
            }
        });
    }

    function loadgroupcategory(categoryID, value1) {
        $.ajax({
            type: "POST",
            data: {
                categoryID: categoryID
            },
            url: 'getprocess/getmaincategorylist.php',
            success: function (result) { //alert(result);
                var objfirst = JSON.parse(result);
                var html = '';
                // html += '<option value="">Select</option>';
                $.each(objfirst, function (i, item) {
                    //alert(objfirst[i].id);
                    html += '<option value="' + objfirst[i].groupid + '">';
                    html += objfirst[i].groupname;
                    html += '</option>';
                });

                $('#groupcategory').empty().append(html);

                if (value1 != '') {
                    $('#groupcategory').val(value);
                }
            }
        });
    }
</script>
<?php include "include/footer.php"; ?>

