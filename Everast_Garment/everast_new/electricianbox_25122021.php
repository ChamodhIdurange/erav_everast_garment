<?php 
include "include/header.php";  

$sql="SELECT `eb`.`idtbl_electrician_box`, `eb`.`recieveddate`, `eb`.`quantity`, `eb`.`totalstarpoints`, `p`.`product_name`, `p`.`idtbl_product`, `e`.`idtbl_electrician`, `e`.`name` FROM `tbl_electrician_box` as `eb` JOIN `tbl_electrician` as `e` ON (`e`.`idtbl_electrician` = `eb`.`tbl_electrician_idtbl_electrician`) JOIN `tbl_product` as `p` ON (`p`.`idtbl_product` = `eb`.`tbl_product_idtbl_product`)";
$result =$conn-> query($sql); 

$sqlproduct="SELECT `idtbl_product`, `product_name` FROM `tbl_product` WHERE `status`=1";
$resultproduct=$conn->query($sqlproduct);

$sqlelectrician="SELECT `idtbl_electrician`, `name` FROM `tbl_electrician` WHERE `status` in (1,2)";
$resultelectrician =$conn-> query($sqlelectrician); 

; 

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
                            <div class="page-header-icon"><i data-feather="briefcase"></i></div>
                            <span>Electrician Boxes</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-outline-primary btn-sm " id = "addbtn" data-toggle="modal"
                                    data-target="#modelform">
                                    <i class="fa fa-plus"></i>&nbsp;Add
                                </button>

                            </div>

                        </div>
                        <div class="row">

                            <div class="col-12">
                                <br>
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Electrician</th>
                                                <th>Product</th>
                                                <th>Received Date</th>
                                                <th>Quantity</th>
                                                <th>Star Points</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($result->num_rows > 0) {while ($row = $result-> fetch_assoc()) { ?>
                                            <tr>
                                                <td><?php echo $row['idtbl_electrician_box'] ?></td>
                                                <td><?php echo $row['name'] ?></td>
                                                <td><?php echo $row['product_name'] ?></td>
                                                <td><?php echo $row['recieveddate'] ?></td>
                                                <td><?php echo $row['quantity'] ?></td>
                                                <td><?php echo $row['totalstarpoints'] ?></td>
                                                <td class="text-center">
                                                    <button class="btn btn-outline-primary btn-sm btnEdit"
                                                        id="<?php echo $row['idtbl_electrician_box'] ?>"
                                                        data-toggle="tooltip"
                                                        data-original-title="View list image"><i
                                                            data-feather="edit"></i></button>
                                          
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

<!-- Form model -->
<div class="modal fade" id="modelform" tabindex="-1" aria-labelledby="modelform" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelcustomized">Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">

                        <form action="process/electricianboxprocess.php" method="post" autocomplete="off"
                            enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Electrician*</label>
                                        <select type="text" class="form-control form-control-sm" name="electrician"
                                            id="electrician">
                                            <option value="">Select</option>
                                            <?php if($resultelectrician->num_rows > 0) {while ($rowtypelist1 = $resultelectrician-> fetch_assoc()) { ?>
                                            <option value="<?php echo $rowtypelist1['idtbl_electrician'] ?>">
                                                <?php echo $rowtypelist1['name'] ?></option>

                                            <?php }} ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Product*</label>
                                        <select type="text" class="form-control form-control-sm" name="product"
                                            id="product">
                                            <option value="">Select</option>
                                            <?php if($resultproduct->num_rows > 0) {while ($rowtypelist1 = $resultproduct-> fetch_assoc()) { ?>
                                            <option value="<?php echo $rowtypelist1['idtbl_product'] ?>">
                                                <?php echo $rowtypelist1['product_name'] ?></option>

                                            <?php }} ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Star points per box*</label>
                                        <input id="starpoints" type="number" name="starpoints"
                                            class="form-control form-control-sm" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Quantity*</label>
                                        <input id="qty" type="number" name="qty" class="form-control form-control-sm"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Total Star Points</label>
                                        <input id="totstarpoints" type="number" name="totstarpoints"
                                            class="form-control form-control-sm"required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label class="small font-weight-bold text-dark">Added date*</label>
                                        <input id="addeddate" type="date" name="addeddate"
                                            class="form-control form-control-sm" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <button type="submit" id="submitBtn"
                                    class="btn btn-outline-primary btn-sm px-5 fa-pull-right"><i
                                        class="far fa-save"></i>&nbsp;Add</button>
                            </div>
                            <input type="hidden" name="recordOption" id="recordOption" value="1">
                            <input type="hidden" name="recordID" id="recordID" value="">
                            <input type="hidden" name="prevstarpoints" id="prevstarpoints" value="">
                            <input type="hidden" name="elecid" id="elecid" value="">
                        </form>
                    </div>


                </div>
            </div>

        </div>
    </div>
</div>

<?php include "include/footerscripts.php"; ?>
<script>
    $(document).ready(function () {
        $("#qty").keyup(calculate);
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
                    url: 'getprocess/getelectricianbox.php',
                    success: function (result) { //alert(result);
                        var obj = JSON.parse(result);
                        
                        $('#recordID').val(obj.id);
                        $('#totstarpoints').val(obj.totalstarpoints);
                        $('#qty').val(obj.quantity);
                        $('#product').val(obj.product);
                        $('#electrician').val(obj.electrician);
                        $('#addeddate').val(obj.recieveddate);
                        $('#elecid').val(obj.electrician);

                        var perboxpoints = obj.totalstarpoints/obj.quantity
                        $('#starpoints').val(perboxpoints);
                        $('#prevstarpoints').val(obj.totalstarpoints);



                        // loadsubcategory(obj.category, obj.subcategory);   
                        // loadgroupcategory(obj.category, obj.groupcategory);   

                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                        $('#electrician').attr("disabled", true) 

                        $('#modelform').modal('show');

                    }
                });
            }
        });

    });


    $( "#addbtn" ).click(function() {
        $('#electrician').attr("disabled", false) 
    });

    $('#product').change(function () {
        $('#starpoints').val(0);
        var productID = $('#product option:selected').val();
        var value = '';

        loadstarpoints(productID, value);

    })

    function loadstarpoints(productID, value) {
        $.ajax({
            type: "POST",
            data: {
                productID: productID
            },
            url: 'getprocess/getstarpoints.php',
            success: function (result) { //alert(result);
                var obj = JSON.parse(result);

                $('#starpoints').val(obj.points);

             
            }
        });
    }


    function calculate() {
        var points = $('#starpoints').val();
        var qty = $('#qty').val();
        var tot = points * qty;

        $('#totstarpoints').val(tot);


    }
</script>
<?php include "include/footer.php"; ?>