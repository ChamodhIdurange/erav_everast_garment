<?php 
require_once('../connection/db.php');
$newarray = array();

$salesManagerId = $_POST['salesManagerId'];
$today = date('Y-m-d');

$getEmployees = "SELECT `idtbl_employee`, `name` FROM `tbl_employee` WHERE `tbl_sales_manager_idtbl_sales_manager` = '$salesManagerId'";
$resultEmployees = $conn->query($getEmployees);

if ($resultEmployees->num_rows > 0) {
    while ($rowEmployee = $resultEmployees->fetch_assoc()) {
        $empId = $rowEmployee['idtbl_employee'];
        $empName = $rowEmployee['name'];

        $sqlfulltot = "SELECT SUM(`u`.`nettotal`) AS 'fulltotal'
                    FROM `tbl_customer_order` AS `u`
                    WHERE `u`.`tbl_employee_idtbl_employee` = '$empId'
                    AND MONTH(`u`.`date`) = MONTH(CURDATE())";
        $resultfulltot = $conn->query($sqlfulltot);
        $fulltotal = ($resultfulltot && $row = $resultfulltot->fetch_assoc()) ? $row['fulltotal'] : 0;

        $sqldailytot = "SELECT SUM(`u`.`nettotal`) AS 'dailytotal'
                        FROM `tbl_customer_order` AS `u`
                        WHERE `u`.`tbl_employee_idtbl_employee` = '$empId'
                        AND `u`.`date` = '$today'";
        $resultdailytot = $conn->query($sqldailytot);
        $dailytotal = ($resultdailytot && $row = $resultdailytot->fetch_assoc()) ? $row['dailytotal'] : 0;

        $sqlgetalltot = "SELECT SUM(`u`.`nettotal`) AS 'fullalltot'
                        FROM `tbl_invoice` AS `u`
                        LEFT JOIN `tbl_customer_order` AS `ud` ON `u`.`tbl_customer_order_idtbl_customer_order` = `ud`.`idtbl_customer_order`
                        WHERE `u`.`status` = '1' 
                        AND `u`.`paymentcomplete` = '0'
                        AND `ud`.`tbl_employee_idtbl_employee` = '$empId'";
        $resultgetalltot = $conn->query($sqlgetalltot);
        $fullalltot = ($resultgetalltot && $row = $resultgetalltot->fetch_assoc()) ? $row['fullalltot'] : 0;

        $sqlpayedamount = "SELECT COALESCE(SUM(`ue`.`payamount`), 0) AS 'totpayedamount'
                            FROM `tbl_invoice` AS `u`
                            LEFT JOIN `tbl_customer_order` AS `ud` ON `u`.`tbl_customer_order_idtbl_customer_order` = `ud`.`idtbl_customer_order`
                            LEFT JOIN `tbl_invoice_payment_has_tbl_invoice` AS `ue` ON `ue`.`tbl_invoice_idtbl_invoice` = `u`.`idtbl_invoice`
                            WHERE `u`.`status` = '1' 
                            AND `u`.`paymentcomplete` = '0'
                            AND `ud`.`tbl_employee_idtbl_employee` = '$empId'";
        $resultpayedamount = $conn->query($sqlpayedamount);
        $fullpayedamount = ($resultpayedamount && $row = $resultpayedamount->fetch_assoc()) ? $row['totpayedamount'] : 0;

        $balance = $fullalltot - $fullpayedamount;

        if($fulltotal == null){
            $fulltotal = 0;
        }
        if($dailytotal == null){
            $dailytotal = 0;
        }
        if($balance == null){
            $balance = 0;
        }
        $response = array(
            "empId"  => $empId,
            "empName"  => $empName,
            "fulltotal"  => $fulltotal,
            "dailytotal" => $dailytotal,
            "outstandingtotal" => $balance,
            "date"       => $today
        );

        $newarray[] = $response;
    }
} else {
    $newarray[] = array("error" => "No employees found");
}

echo json_encode($newarray);

?>
