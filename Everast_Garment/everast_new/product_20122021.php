<?php 
include "include/header.php";  

$sql="SELECT * FROM `tbl_product` WHERE `status` IN (1,2)";
$result =$conn-> query($sql); 

$sqlcategory="SELECT `idtbl_product_category`, `category` FROM `tbl_product_category` WHERE `status`=1";
$resultcategory=$conn->query($sqlcategory);

$sqlsubcategory="SELECT `idtbl_sub_product_category`, `category` FROM `tbl_sub_product_category` WHERE `status`= 1";
$resultsubcategory=$conn->query($sqlsubcategory);

$sqlgroupcategory="SELECT `idtbl_tbl_group_category`, `category` FROM `tbl_group_category` WHERE `status`=1";
$resultgroupcategory=$conn->query($sqlgroupcategory);

$sqlsupplier="SELECT `idtbl_supplier`, `suppliername` FROM `tbl_supplier` WHERE `status`=1";
$resultsupplier=$conn->query($sqlsupplier);

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
                            <div class="col-3">
                                <form action="process/productprocess.php" method="post" autocomplete="off">
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Supplier Name*</label>
                                            <select class="form-control form-control-sm" name="supplier" id="supplier"
                                                required>
                                                <option value="">Select</option>
                                                <?php if($resultsupplier->num_rows > 0) {while ($rowcategory = $resultsupplier-> fetch_assoc()) { ?>
                                                <option value="<?php echo $rowcategory['idtbl_supplier'] ?>">
                                                    <?php echo $rowcategory['suppliername'] ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Product*</label>
                                        <input id="productName" type="text" name="productName"
                                            class="form-control form-control-sm" placeholder="">
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Product Code</label>
                                        <input id="productcode" type="text" name="productcode"
                                            class="form-control form-control-sm" placeholder="">
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Bar Code</label>
                                        <input id="barcode" type="text" name="barcode"
                                            class="form-control form-control-sm" placeholder="">
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Unit Price</label>
                                            <input id="unitprice" type="text" name="unitprice"
                                                class="form-control form-control-sm" placeholder="">
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Sale Price</label>
                                            <input id="saleprice" type="text" name="saleprice"
                                                class="form-control form-control-sm" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Main Category*</label>
                                            <select class="form-control form-control-sm" name="category" id="category"
                                                required>
                                                <option value="">Select</option>
                                                <?php if($resultcategory->num_rows > 0) {while ($rowcategory = $resultcategory-> fetch_assoc()) { ?>
                                                <option value="<?php echo $rowcategory['idtbl_product_category'] ?>">
                                                    <?php echo $rowcategory['category'] ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Sub Category*</label>
                                            <select class="form-control form-control-sm" name="subcategory" id="subcategory"
                                                required>
                                                <option value="">Select</option>
                                                <?php if($resultsubcategory->num_rows > 0) {while ($rowcategory = $resultsubcategory-> fetch_assoc()) { ?>
                                                <option
                                                    value="<?php echo $rowcategory['idtbl_sub_product_category'] ?>">
                                                    <?php echo $rowcategory['category'] ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Group Category*</label>
                                            <select class="form-control form-control-sm" name="groupcategory" id="groupcategory"
                                                required>
                                                <option value="">Select</option>
                                                <?php if($resultgroupcategory->num_rows > 0) {while ($rowcategory = $resultgroupcategory-> fetch_assoc()) { ?>
                                                <option value="<?php echo $rowcategory['idtbl_tbl_group_category'] ?>">
                                                    <?php echo $rowcategory['category'] ?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">ROL</label>
                                            <input id="rol" type="text" name="rol" class="form-control form-control-sm"
                                                placeholder="">
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Pieces per box</label>
                                            <input id="peices" type="text" name="peices"
                                                class="form-control form-control-sm" placeholder="">
                                        </div>
                                    </div>

                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Max Discount(%)</label>
                                        <input id="maxdiscount" type="number" name="maxdiscount"
                                            class="form-control form-control-sm" max="100" placeholder="">
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Retail</label>
                                        <input id="retail" type="text" name="retail"
                                            class="form-control form-control-sm" placeholder="">
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Star points</label>
                                        <input id="starpoints" type="text" name="starpoints"
                                            class="form-control form-control-sm" max="100" placeholder="">
                                    </div>
                                    <div class="col form-group form-check">
                                        <input type="checkbox" class="form-check-input" id="discount">
                                        <label class="form-check-label" for="discount">Discount Applicable</label>
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
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>Code</th>
                                                <th>Category</th>
                                                <th>Unit Price</th>
                                                <th>Sale Price</th>
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
                                                <td><?php echo number_format($row['unitprice'], 2) ?></td>
                                                <td><?php echo number_format($row['saleprice'], 2) ?></td>
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
        $('#dataTable').DataTable();
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
                        $('#maxdiscount').val(obj.maxdiscount);
                        $('#starpoints').val(obj.starpoints);
                        $('#category').val(obj.category);
                        $('#groupcategory').val(obj.groupcategory);
                        $('#subcategory').val(obj.subcategory);
                        $('#supplier').val(obj.supplier);

                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                    }
                });
            }
        });
    });
</script>
<?php include "include/footer.php"; ?>