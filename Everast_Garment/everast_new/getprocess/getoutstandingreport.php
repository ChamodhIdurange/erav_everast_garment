<?php 
require_once('../connection/db.php');

$validfrom = $_POST['validfrom'];
$validto = $_POST['validto'];
$customerID = isset($_POST['customer']) ? $_POST['customer'] : 0;
$repID = isset($_POST['rep']) ? $_POST['rep'] : 0;

$date = date('Y-m-d');

$customerarray = array();
$totalAmount = 0;

$sql = "SELECT `u`.`idtbl_invoice`,`u`.`invoiceno`, `u`.`total`, `u`.`date`, `uc`.`name` AS `cusname`, `ue`.`name` AS `repname`
        FROM `tbl_invoice` AS `u`
        LEFT JOIN `tbl_customer` AS `uc` ON `u`.`tbl_customer_idtbl_customer` = `uc`.`idtbl_customer`
        LEFT JOIN `tbl_customer_order` AS `ud` ON `u`.`tbl_customer_order_idtbl_customer_order` = `ud`.`idtbl_customer_order`
        LEFT JOIN `tbl_employee` AS `ue` ON `ud`.`tbl_employee_idtbl_employee` = `ue`.`idtbl_employee`
        WHERE `u`.`status`=1 
        AND `u`.`paymentcomplete`=0 
        AND `u`.`date` BETWEEN '$validfrom' AND '$validto'";

if ($customerID > 0) {
    $sql .= " AND `u`.`tbl_customer_idtbl_customer` = '$customerID'";
}
if ($repID > 0) {
    $sql .= " AND `ue`.`idtbl_employee` = '$repID'";
}

$sql .= " GROUP BY `u`.`idtbl_invoice`";

$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<div style=\"color: red; font-size:20px;\">No Records</div>";
    return;
}

while($row = $result->fetch_assoc()) {
    array_push($customerarray, $row);
    $totalAmount += $row['total'];

    $date = new DateTime($row['date']);
    $today = new DateTime();  
    $interval = $today->diff($date);  
    $datecount = $interval->days;  
}

$html = '<table class="table table-striped table-bordered table-sm small" id="outstandingReportTable">
    <thead>
        <tr>
            <th>Customer</th>
            <th class="text-center">Rep</th>
            <th class="text-center">Date</th>
            <th class="text-center">Days</th>
            <th class="text-center">Invoice</th>
            <th class="text-center">Invoice Total</th>
        </tr>
    </thead>
    <tbody>';

foreach($customerarray as $rowcustomerarray) { 
    $html .= '<tr>
        <td>' . htmlspecialchars($rowcustomerarray['cusname']) . '</td>
        <td class="text-center">' . htmlspecialchars($rowcustomerarray['repname']) . '</td>
        <td class="text-center">' . htmlspecialchars($rowcustomerarray['date']) . '</td>
        <td class="text-center">' . $datecount . '</td>
        <td class="text-center">' . htmlspecialchars($rowcustomerarray['invoiceno']) . '</td>
        <td class="text-center">' . number_format(htmlspecialchars($rowcustomerarray['total'])) . '</td>
    </tr>';
}

$html .= '</tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-center"><strong>Total</strong></td>
            <td class="text-center"><strong>' . number_format(htmlspecialchars($totalAmount)) . '</strong></td>
        </tr>
    </tfoot>
</table>';

echo $html;
?>
