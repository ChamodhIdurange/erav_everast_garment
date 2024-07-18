<?php
include "connection/db.php";
include "include/header.php";
include "include/topnavbar.php";

$today_date = date('Y-m-d');

$sql = "SELECT `u`.`product_code`, `u`.`product_name`, `ua`.`qty`, `ua`.`batchno`, `ua`.`update` FROM `tbl_stock` AS `ua` LEFT JOIN `tbl_product` AS `u` ON (`ua`.`tbl_product_idtbl_product` = `u`.`idtbl_product`) WHERE `u`.`status` ='1'";
$resstock = $conn->query($sql);

$sql = "SELECT COUNT(`idtbl_product`) AS `count` FROM `tbl_product`  WHERE `status` ='1'";
$resproduct = $conn->query($sql);
$rowproduct = $resproduct->fetch_assoc();
$itemcount = $rowproduct['count'];
$todaysaleprice = 0;
$pendingsaleprice = 0;
$returnsaleprice = 0;
$monthsaleprice = 0;
$todayqty = 0;
$pendingqty = 0;
$returnqty = 0;
$monthyqty = 0;

$sqlmaintable = "SELECT 
`ud`.`name`, 
`ub`.`area`, 
SUM(CASE WHEN DATE(`u`.`orderdate`) = CURDATE() THEN `uz`.`qty` ELSE 0 END) AS todayqty,
SUM(CASE WHEN DATE(`u`.`orderdate`) = CURDATE() THEN `u`.`nettotal` ELSE 0 END) AS todaysaleprice,
SUM(CASE WHEN `u`.`deliverystatus` = 0 AND DATE(`u`.`orderdate`) = CURDATE() THEN `uz`.`qty` ELSE 0 END) AS pendingqty,
SUM(CASE WHEN `u`.`deliverystatus` = 0 AND DATE(`u`.`orderdate`) = CURDATE() THEN `u`.`nettotal` ELSE 0 END) AS pendingsaleprice,
SUM(CASE WHEN `u`.`returnstatus` = 0 AND DATE(`u`.`orderdate`) = CURDATE() THEN `uz`.`qty` ELSE 0 END) AS returnqty,
SUM(CASE WHEN `u`.`returnstatus` = 0 AND DATE(`u`.`orderdate`) = CURDATE() THEN `u`.`nettotal` ELSE 0 END) AS returnsaleprice,
SUM(CASE WHEN MONTH(`u`.`orderdate`) = MONTH(CURDATE()) THEN `uz`.`qty` ELSE 0 END) AS monthyqty,
SUM(CASE WHEN MONTH(`u`.`orderdate`) = MONTH(CURDATE()) THEN `u`.`nettotal` ELSE 0 END) AS monthsaleprice,
`u`.`idtbl_porder`
FROM 
`tbl_porder` AS `u` 
LEFT JOIN 
`tbl_porder_otherinfo` AS `ua` ON (`ua`.`porderid` = `u`.`idtbl_porder`) 
LEFT JOIN 
`tbl_area` AS `ub` ON (`ub`.`idtbl_area` = `ua`.`areaid`) 
LEFT JOIN 
`tbl_customer` AS `uc` ON (`uc`.`idtbl_customer` = `ua`.`customerid`) 
LEFT JOIN 
`tbl_employee` AS `ud` ON (`ud`.`idtbl_employee` = `ua`.`repid`) 
LEFT JOIN 
`tbl_porder_detail` AS `uz` ON (`uz`.`tbl_porder_idtbl_porder` = `u`.`idtbl_porder`) 
WHERE 
DATE(`u`.`orderdate`) = CURDATE() OR 
(`u`.`deliverystatus` = 0 AND DATE(`u`.`orderdate`) = CURDATE()) OR 
MONTH(`u`.`orderdate`) = MONTH(CURDATE()) 
GROUP BY 
`u`.`idtbl_porder`
";
$resmain = $conn->query($sqlmaintable);
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php
        include "include/menubar.php";
        ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title font-weight-light">
                            <div class="page-header-icon"><i class="fas fa-desktop"></i></div>
                            <span>Dashboard</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card rounded-0">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                        </div>

                        <div class="row">
                            <div class="col-7">
                                <div>Outbound Summary</div>
                                <hr class="border-dark">
                                <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="border : 1px solid gray" class="text-center small">Territory</th>
                                            <th rowspan="2" style="border : 1px solid gray" class="text-center small">Rep</th>
                                            <th colspan="2" style="border : 1px solid gray" class="text-center small">Today Order</th>
                                            <th colspan="2" style="border : 1px solid gray" class="text-center small">Pending Deliveries</th>
                                            <th colspan="2" style="border : 1px solid gray" class="text-center small">Monthly Sales</th>
                                            <th colspan="2" style="border : 1px solid gray" class="text-center small">Monthly Returns</th>
                                            <th rowspan="2" style="border : 1px solid gray" class="text-center small">GP</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center small" style="border : 1px solid gray">Qty</th>
                                            <th class="text-center small" style="border : 1px solid gray">Value</th>
                                            <th class="text-center small" style="border : 1px solid gray">Qty</th>
                                            <th class="text-center small" style="border : 1px solid gray">Value</th>
                                            <th class="text-center small" style="border : 1px solid gray">Qty</th>
                                            <th class="text-center small" style="border : 1px solid gray">Value</th>
                                            <th class="text-center small" style="border : 1px solid gray">Qty</th>
                                            <th class="text-center small" style="border : 1px solid gray">Value</th>

                                        </tr>
                                        <?php while ($row2 = $resmain->fetch_assoc()) {
                                            $todaysaleprice += $row2['todaysaleprice'];
                                            $pendingsaleprice += $row2['pendingsaleprice'];
                                            $returnsaleprice += $row2['returnsaleprice'];
                                            $monthsaleprice += $row2['monthsaleprice'];
                                            $todayqty += $row2['todayqty'];
                                            $pendingqty += $row2['pendingqty'];
                                            $returnqty += $row2['monthyqty'];
                                            $monthyqty += $row2['returnqty'];
                                        ?>
                                            <tr>
                                                <th class="text-center small" style="border : 1px solid gray"><?php echo $row2['area']; ?></th>
                                                <th class="text-center small" style="border : 1px solid gray"><?php echo $row2['name']; ?></th>
                                                <th class="text-center small" style="border : 1px solid gray"><?php echo $row2['todayqty']; ?></th>
                                                <th class="text-center small" style="border : 1px solid gray"><?php echo number_format($row2['todaysaleprice'], 2, '.', ','); ?></th>
                                                <th class="text-center small" style="border : 1px solid gray"><?php echo $row2['pendingqty']; ?></th>
                                                <th class="text-center small" style="border : 1px solid gray"><?php echo number_format($row2['pendingsaleprice'], 2, '.', ','); ?></th>
                                                <th class="text-center small" style="border : 1px solid gray"><?php echo $row2['monthyqty']; ?></th>
                                                <th class="text-center small" style="border : 1px solid gray"><?php echo number_format($row2['monthsaleprice'], 2, '.', ','); ?></th>

                                                <th class="text-center small" style="border : 1px solid gray"><?php echo $row2['returnqty']; ?></th>
                                                <th class="text-center small" style="border : 1px solid gray"><?php echo number_format($row2['returnsaleprice'], 2, '.', ','); ?></th>
                                                <th class="text-center small" style="border : 1px solid gray">##.##</th>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <th colspan="2" class="text-center small" style="border : 1px solid gray"></th>
                                            <th class="text-center small" style="border : 1px solid gray"><?php echo $todayqty; ?></th>
                                            <th class="text-center small" style="border : 1px solid gray"><?php echo number_format($todaysaleprice, 2, '.', ','); ?></th>
                                            <th class="text-center small" style="border : 1px solid gray"><?php echo $pendingqty; ?></th>
                                            <th class="text-center small" style="border : 1px solid gray"><?php echo number_format($pendingsaleprice, 2, '.', ','); ?></th>
                                            <th class="text-center small" style="border : 1px solid gray"><?php echo $monthyqty; ?></th>
                                            <th class="text-center small" style="border : 1px solid gray"><?php echo number_format($monthsaleprice, 2, '.', ','); ?></th>
                                            <th class="text-center small" style="border : 1px solid gray"><?php echo $returnqty; ?></th>
                                            <th class="text-center small" style="border : 1px solid gray"><?php echo number_format($returnsaleprice, 2, '.', ','); ?></th>
                                            <th class="text-center small" style="border : 1px solid gray">##.##</th>
                                        </tr>
                                    </thead>
                                </table>
                                <hr class="border-dark">
                                <div>Stock Summary</div>
                                <hr class="border-dark">
                                <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th style="border : 1px solid gray" class="text-center small">Item Code</th>
                                            <th style="border : 1px solid gray" class="text-center small">Item Name</th>
                                            <th style="border : 1px solid gray" class="text-center small">Batch Date</th>
                                            <th style="border : 1px solid gray" class="text-center small">Batch NO</th>
                                            <th style="border : 1px solid gray" class="text-center small">QTY</th>
                                            <!-- <th style="border : 1px solid gray" class="text-center small">Del Returns</th>
                                            <th style="border : 1px solid gray" class="text-center small">Sal Returns</th>
                                            <th style="border : 1px solid gray" class="text-center small">Available</th>
                                            <th style="border : 1px solid gray" class="text-center small">Pen Orders</th>
                                            <th style="border : 1px solid gray" class="text-center small">Balance</th> -->
                                        </tr>
                                        <?php while ($row = $resstock->fetch_assoc()) { ?>
                                            <tr>
                                                <th class="text-center small" style="border : 1px solid gray"><?php echo $row['product_code']; ?></th>
                                                <th class="text-center small" style="border : 1px solid gray"><?php echo $row['product_name']; ?></th>
                                                <th class="text-center small" style="border : 1px solid gray"><?php echo $row['update']; ?></th>
                                                <th class="text-center small" style="border : 1px solid gray"><?php echo $row['batchno']; ?></th>
                                                <th class="text-center small" style="border : 1px solid gray"><?php echo $row['qty']; ?></th>
                                                <!-- <th class="text-center small" style="border : 1px solid gray">2000</th>
                                            <th class="text-center small" style="border : 1px solid gray">3</th>
                                            <th class="text-center small" style="border : 1px solid gray">3000</th>
                                            <th class="text-center small" style="border : 1px solid gray">4</th>
                                            <th class="text-center small" style="border : 1px solid gray">40</th> -->

                                            </tr>
                                        <?php } ?>
                                    </thead>
                                </table>
                            </div>
                            <div class="col-5">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="">
                                            <div class="card shadow-none border-dark bg-success card-icon p-0 mb-3">
                                                <div class="row no-gutters h-100">
                                                    <div class="col-auto p-2 text-white">
                                                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="col">
                                                        <div class="card-body p-0 px-2 py-2 text-center">
                                                            <h1 class=" text-white my-1" style="font-size: 30px;">
                                                                <?php echo $itemcount ?>
                                                            </h1>
                                                            <h5 class="card-title text-white m-0 font-weight-bold">
                                                                Item Range
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row no-gutters h-100">
                                                    <div class="col">
                                                        <div class="card-body p-0 p-2 text-right">
                                                            <div class="progress" style="height: 3px;">
                                                                <div class="progress-bar bg-white" role="progressbar" style="width: 100%;" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="">
                                            <div class="card shadow-none border-dark bg-danger card-icon p-0 mb-3">
                                                <div class="row no-gutters h-100">
                                                    <div class="col-auto p-2 text-white">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="col">
                                                        <div class="card-body p-0 px-2 py-2 text-center">
                                                            <h1 class=" text-white my-1" style="font-size: 30px;">
                                                                <?php echo date("D-M-Y"); ?>
                                                            </h1>
                                                            <h5 class="card-title text-white m-0 font-weight-bold">
                                                                <?php echo date("h:i a") ?>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row no-gutters h-100">
                                                    <div class="col">
                                                        <div class="card-body p-0 p-2 text-right">
                                                            <div class="progress" style="height: 3px;">
                                                                <div class="progress-bar bg-white" role="progressbar" style="width: 100%;" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
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
    $(document).ready(function() {


        $('#dataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: "scripts/dashboardlist.php",
                type: "POST", // you can use GET
                data: function(d) {
                    d.userID = '<?php echo $_SESSION['userid']; ?>';
                }
            },
            "order": [
                [0, "desc"]
            ],
            "columns": [ //{

                //         "data": "idheader"
                //     }, 
                //     {
                //         "data": "billno",
                //         "render": function(data, type, full) {

                //             var insertdatetime = full['insertdatetime'];

                //             return '<span data-toggle="tooltip" title="' + insertdatetime + '">' + data + '</span>';

                //         }
                //     },
                //     {
                //         "targets": -1,
                //         "className": 'text-center',
                //         "data": "checked",
                //         "render": function(data, type, full) {
                //             var insertdatetime = full['insertdatetime'];
                //             var checkedValue = data == 1 ? '<i class="fas fa-check text-success mt-2"></i>' : '<i class="fas fa-times text-danger mt-2"></i>';
                //             return '<span data-toggle="tooltip" title="' + insertdatetime + '">' + checkedValue + '</span>';
                //         }
                //     },
                //     {
                //         "targets": -1,
                //         "className": 'text-center',
                //         "data": "checked_issue",
                //         "render": function(data, type, full) {
                //             var ua_insertdatetime = full['ua_insertdatetime'];
                //             var checkedfab = data == 1 ? '<i class="fas fa-check text-success mt-2"></i>' : '<i class="fas fa-times text-danger mt-2"></i>';
                //             return '<span data-toggle="tooltip" title="' + ua_insertdatetime + '">' + checkedfab + '</span>';

                //         }
                //     },
                //     {
                //         "targets": -1,
                //         "className": 'text-center',
                //         "data": "checked_in",
                //         "render": function(data, type, full) {
                //             var ub_insertdatetime = full['ub_insertdatetime'];
                //             var checkedcutin = data == 1 ? '<i class="fas fa-check text-success mt-2"></i>' : '<i class="fas fa-times text-danger mt-2"></i>';
                //             return '<span data-toggle="tooltip" title="' + ub_insertdatetime + '">' + checkedcutin + '</span>';
                //         }
                //     },
                //     {
                //         "targets": -1,
                //         "className": 'text-center',
                //         "data": "checked_out",
                //         "render": function(data, type, full) {
                //             var uc_insertdatetime = full['uc_insertdatetime'];
                //             var checkedcutout = data == 1 ? '<i class="fas fa-check text-success mt-2"></i>' : '<i class="fas fa-times text-danger mt-2"></i>';
                //             return '<span data-toggle="tooltip" title="' + uc_insertdatetime + '">' + checkedcutout + '</span>';
                //         }

                //     },
                //     {

                //         "data": "time_difference"
                //     },

            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    });
</script>
<?php include "include/footer.php"; ?>