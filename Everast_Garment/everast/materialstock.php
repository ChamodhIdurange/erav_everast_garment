<?php 
include "include/header.php";  

$sqlstock="SELECT `p`.`retail`, `p`.`materialname`, `s`.`qty`, `s`.`batchqty`, `s`.`batchno` FROM `tbl_material_stock` as `s` JOIN `tbl_material` as `p` ON (`p`.`idtbl_material`=`s`.`tbl_material_idtbl_material`)";
$resultstock =$conn-> query($sqlstock); 

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
                            <span>Material Stock Report</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row row-cols-1 row-cols-md-2" id="printarea">
                            <div class="col-md-12">
                                <h6 class="small title-style"><span>Main stock</span></h6>
                                <table  class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Retail price</th>
                                            <th>Batch</th>
                                            <th class="text-center">Grn Stock</th>
                                            <th class="text-center">Available Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($resultstock->num_rows > 0) {while ($rowstock = $resultstock-> fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $rowstock['materialname'] ?></td>
                                            <td class="text-right">Rs.<?php echo $rowstock['retail'] ?>.00</td>
                                            <td class="text-right"><?php echo $rowstock['batchno'] ?></td>
                                            <td class="text-center"><?php echo $rowstock['batchqty'] ?></td>
                                            <td class="text-center"><?php echo $rowstock['qty'] ?></td>
                                        </tr>
                                        <?php }} ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                  
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-outline-danger btn-sm fa-pull-right" id="btnprint"><i
                                        class="fas fa-print"></i>&nbsp;Print Report</button>
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
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        })
        document.getElementById('btnprint').addEventListener("click", print);
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