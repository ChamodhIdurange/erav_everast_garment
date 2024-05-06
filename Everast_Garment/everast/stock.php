<?php 
include "include/header.php";  

// $sqlstock="SELECT `p`.`retail`, `sp`.`category` as `subcat`, `gp`.`category` as `groupcat`,`pc`.`category` as `maincat`, `p`.`product_name`, `s`.`qty`, `s`.`batchqty`, `s`.`batchno`FROM `tbl_stock` as `s` JOIN `tbl_product` as `p` ON (`p`.`idtbl_product`=`s`.`tbl_product_idtbl_product`) JOIN `tbl_product_category` AS `pc` ON (`p`.`tbl_product_category_idtbl_product_category` = `pc`.`idtbl_product_category`) JOIN `tbl_sub_product_category` AS `sp` ON (`p`.`tbl_sub_product_category_idtbl_sub_product_category` = `sp`.`idtbl_sub_product_category`) JOIN `tbl_group_category` AS `gp` ON (`p`.`tbl_group_category_idtbl_group_category` = `gp`.`idtbl_group_category`) WHERE `s`.`status`=1 AND `p`.`status`=1";
// $resultstock =$conn-> query($sqlstock); 

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
                            <div class="page-header-icon"><i data-feather="file"></i></div>
                            <span>Stock Report</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                                <form id="searchform">
                                    <div class="form-row">
                                        <div class="col-3">
                                            <label class="small font-weight-bold text-dark">Date*</label>
                                            <div class="input-group input-group-sm mb-3">
                                                <input type="text" class="form-control dpd1a rounded-0" id="fromdate"
                                                    name="fromdate" value="<?php echo date('Y-m-d') ?>" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text rounded-0"
                                                        id="inputGroup-sizing-sm"><i data-feather="calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">&nbsp;</label><br>
                                            <button class="btn btn-outline-dark btn-sm rounded-0 px-4" type="button"
                                                id="formSearchBtn"><i class="fas fa-search"></i>&nbsp;Search</button>
                                        </div>
                                    </div>
                                    <input type="submit" class="d-none" id="hidesubmit">
                                </form>
                            </div>
                            <div class="col-12">
                                <hr class="border-dark">
                                <div id="targetviewdetail"></div>
                                <!-- <canvas id="salechart"></canvas> -->
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
        $('.dpd1a').datepicker('remove');
        $('.dpd1a').datepicker({
            uiLibrary: 'bootstrap4',
            autoclose: 'true',
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });

    });

    $('#formSearchBtn').click(function () {
        if (!$("#searchform")[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            $("#hidesubmit").click();
        } else {
            var fromdate = $('#fromdate').val();

            $('#targetviewdetail').html(
                '<div class="card border-0 shadow-none bg-transparent"><div class="card-body text-center"><img src="images/spinner.gif" alt="" srcset=""></div></div>'
            );

            $.ajax({
                type: "POST",
                data: {
                    fromdate: fromdate,
                },
                url: 'getprocess/getselectedstock.php',
                success: function (result) { //alert(result);

                    $('#targetviewdetail').html(result);
                }
            });
        }
    });

    function print() {
        printJS({
            printable: 'printarea',
            type: 'html',
            // style: '@page { size: landscape; }',
            targetStyles: ['*']
        })
    }
</script>
<?php include "include/footer.php"; ?>
