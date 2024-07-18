<?php
include "include/header.php";
$sql = "SELECT *, `tbl_catalog_category`.`category`, `tbl_product`.`product_name`, `tbl_catalog`.`status` FROM `tbl_catalog` LEFT JOIN `tbl_catalog_category` ON(`tbl_catalog_category`.`idtbl_catalog_category` = `tbl_catalog`.`tbl_catalog_category_idtbl_catalog_category`) LEFT JOIN `tbl_product` ON(`tbl_product`.`idtbl_product` = `tbl_catalog`.`tbl_product_idtbl_product`) WHERE `tbl_catalog`.`status`IN(1,2)";
$result = $conn->query($sql);

$productarray = array();
$sqlproduct = "SELECT `idtbl_product`, `product_name` FROM `tbl_product` WHERE `status`=1";
$resultproduct = $conn->query($sqlproduct);
while ($rowproduct = $resultproduct->fetch_assoc()) {
    $obj = new stdClass();
    $obj->productID = $rowproduct['idtbl_product'];
    $obj->product = $rowproduct['product_name'];

    array_push($productarray, $obj);
}

$productcatarray = array();
$sqlproductcat = "SELECT `idtbl_catalog_category`, `category` FROM `tbl_catalog_category` WHERE `status`=1";
$resultproductcat = $conn->query($sqlproductcat);
while ($productcat = $resultproductcat->fetch_assoc()) {
    $obj = new stdClass();
    $obj->productcatalogID = $productcat['idtbl_catalog_category'];
    $obj->productcatalogcat = $productcat['category'];

    array_push($productcatarray, $obj);
}
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
                            <div class="page-header-icon"><i class="fa fa-puzzle-piece" aria-hidden="true"></i></div>
                            <span>Product Catalog Display</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-3">
                                <form action="process/productcatalogprocess.php" method="post" autocomplete="off" enctype="multipart/form-data">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Product Catalog Category*</label>
                                        <select class="form-control form-control-sm" name="catalogcat" id="catalogcat" required>
                                            <option value="">Select</option>
                                            <?php foreach ($productcatarray as $rowproductcatlist) { ?>
                                                <option value="<?php echo $rowproductcatlist->productcatalogID ?>"><?php echo $rowproductcatlist->productcatalogcat ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Product*</label>
                                        <select class="form-control form-control-sm" name="product" id="product" required>
                                            <option value="">Select</option>
                                            <?php foreach ($productarray as $rowproductlist) { ?>
                                                <option value="<?php echo $rowproductlist->productID ?>"><?php echo $rowproductlist->product ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Uom</label>
                                        <select class="form-control form-control-sm" name="uom" id="uom" required>
                                            <option value="">Select</option>

                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Type*</label>
                                    </div>
                                    <div class="form-group mb-1">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type" id="type1" value="1">
                                            <label class="form-check-label" for="type1">Single</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type" id="type2" value="2">
                                            <label class="form-check-label" for="type2">Group</label>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label class="small font-weight-bold text-dark">Product Image</label>
                                        <input type="file" name="productimage" id="productimage" class="form-control form-control-sm" style="padding-bottom:32px;">
                                        <small id="" class="form-text text-danger">Image size 800X800 Pixel</small>
                                    </div>
                                    <div class="form-group mt-3">
                                        <button type="submit" id="submitBtn" class="btn btn-outline-primary btn-sm w-50 fa-pull-right" <?php if ($addcheck == 0) {
                                                                                                                                            echo 'disabled';
                                                                                                                                        } ?>><i class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                                    <input type="hidden" name="recordID" id="recordID" value="">
                                </form>
                            </div>
                            <div class="col-9">
                                <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Category</th>
                                            <th>Product</th>
                                            <th>UOM</th>
                                            <th>Type</th>
                                            
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) { ?>
                                                <tr>
                                                    <td><?php echo $row['idtbl_catalog'] ?></td>
                                                    <td><?php echo $row['category'] ?></td>
                                                    <td><?php echo $row['product_name'] ?></td>
                                                    <td><?php if ($row['uom'] == 1) {
                                                            echo "PCS";
                                                        } elseif ($row['uom'] == 2) {
                                                            echo "Packet";
                                                        } elseif ($row['uom'] == 3) {
                                                            echo "Box";
                                                        } elseif ($row['uom'] == 4) {
                                                            echo "Dozen";
                                                        } elseif ($row['uom'] == 5) {
                                                            echo "Kilogram";
                                                        } elseif ($row['uom'] == 6) {
                                                            echo "Bottle";
                                                        } elseif ($row['uom'] == 7) {
                                                            echo "Roll";
                                                        } elseif ($row['uom'] == 8) {
                                                            echo "Tin";
                                                        } elseif ($row['uom'] == 79) {
                                                            echo "Berall";
                                                        } ?></td>
                                                    <td><?php if ($row['group_type'] == 1) {
                                                            echo "Single";
                                                        } else {
                                                            echo "Group";
                                                        } ?></td>
                                                    <td class="text-right">
                                                        <button class="btn btn-outline-secondary btn-sm btnlistview" id="<?php echo $row['idtbl_catalog'] ?>" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="View list image"><i class="fa fa-camera" aria-hidden="true"></i></button>
                                                        <button class="btn btn-outline-primary btn-sm btnEdit <?php if ($editcheck == 0) {
                                                                                                                    echo 'd-none';
                                                                                                                } ?>" id="<?php echo $row['idtbl_catalog'] ?>"><i data-feather="edit-2"></i></button>
                                                        <?php if ($row['status'] == 1) { ?>
                                                            <a href="process/statuscatalog.php?record=<?php echo $row['idtbl_catalog'] ?>&type=2" onclick="return confirm('Are you sure you want to deactive this?');" target="_self" class="btn btn-outline-success btn-sm <?php if ($statuscheck == 0) {
                                                                                                                                                                                                                                                                                    echo 'd-none';
                                                                                                                                                                                                                                                                                } ?>"><i data-feather="check"></i></a>
                                                        <?php } else { ?>
                                                            <a href="process/statuscatalog.php?record=<?php echo $row['idtbl_catalog'] ?>&type=1" onclick="return confirm('Are you sure you want to active this?');" target="_self" class="btn btn-outline-warning btn-sm <?php if ($statuscheck == 0) {
                                                                                                                                                                                                                                                                                    echo 'd-none';
                                                                                                                                                                                                                                                                                } ?>"><i data-feather="x-square"></i></a>
                                                        <?php } ?>
                                                        <a href="process/statuscatalog.php?record=<?php echo $row['idtbl_catalog'] ?>&type=3" onclick="return confirm('Are you sure you want to remove this?');" target="_self" class="btn btn-outline-danger btn-sm <?php if ($deletecheck == 0) {
                                                                                                                                                                                                                                                                                echo 'd-none';
                                                                                                                                                                                                                                                                            } ?>"><i data-feather="trash-2"></i></a>
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
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<!-- Modal Image View -->
<div class="modal fade" id="modalimageview" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-2">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div id="imagelist" class=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
        $('#dataTable tbody').on('click', '.btnEdit', function() {
            var r = confirm("Are you sure, You want to Edit this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: 'getprocess/getcatalogedit.php',
                    success: function(result) {
                        var obj = JSON.parse(result);
                        var uomname;

                        if (obj.uom == 1) {
                            uomname = "PCS";
                        } else if (obj.uom == 2) {
                            uomname = "Packet";
                        }else if (obj.uom == 3) {
                            uomname = "Box";
                        }
                        else if (obj.uom == 4) {
                            uomname = "Dozen";
                        }
                        else if (obj.uom == 5) {
                            uomname = "Kilogram";
                        }
                        else if (obj.uom == 6) {
                            uomname = "Bottle";
                        }
                        else if (obj.uom == 7) {
                            uomname = "Roll";
                        }
                        else if (obj.uom == 8) {
                            uomname = "Tin";
                        }
                        else if (obj.uom == 79) {
                            uomname = "Berall";
                        }
                        

                        $('#recordID').val(obj.id);
                        $('#uom').empty();
                        $('#uom').append($('<option>', {
                            value: obj.uom,
                            text: uomname
                        }));
                        $('#catalogcat').val(obj.tbl_catalog_category_idtbl_catalog_category);
                        if (obj.group_type == 1) {
                            $('#type1').prop('checked', true);
                        } else if (obj.group_type == 2) {
                            $('#type2').prop('checked', true);
                        }
                        $('#product').val(obj.tbl_product_idtbl_product);
                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                    }
                });

            }
        });

        $('#product').on('change', function() {

            var recordID = $(this).val();

            // alert(recordID);

            procategory(recordID, '');

        });

        $('#dataTable tbody').on('click', '.btnlistview', function() {
            var id = $(this).attr('id');
            loadlistimages(id);
            $('#modalimageview').modal('show');

        });

    });

    function procategory(recordID, value) {
        //  alert(value);
        $.ajax({
            type: "POST",
            data: {
                recordID: recordID
            },
            url: 'getprocess/getuomcatalog.php',
            success: function(result) {

                var product = JSON.parse(result);
                //  console.log(product.id);

                $('#uom').empty();

                $('#uom').append('<option value="' + product.id + '">' + product.uom + '</option>');
            }
        });
    }

    function loadlistimages(productID) {
        $('#imagelist').addClass('text-center');
        $('#imagelist').html('<img src="images/spinner.gif" class="img-fluid">');

        $.ajax({
            type: "POST",
            data: {
                productID: productID,
            },
            url: 'getprocess/getproductlistimages.php',
            success: function(result) { //alert(result);
                $('#imagelist').removeClass('text-center');
                $('#imagelist').html(result);
                optionimages(productID);
            }
        });
    }

    function optionimages(productID) {
        $('#productimagetable tbody').on('click', '.btnremoveimage', function() {
            var imageID = $(this).attr('id');
            var r = confirm("Are you sure, You want to Delete this ? ");
            if (r == true) {
                $.ajax({
                    type: "POST",
                    data: {
                        imageID: imageID,

                    },
                    url: 'process/statusproductimages.php',
                    success: function(result) { //alert(result);
                        $('#imagelist').html(result);
                        loadlistimages(productID);
                    }
                });
            }
        });
    }
</script>
<?php include "include/footer.php"; ?>