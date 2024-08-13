<?php 
require_once('../connection/db.php');

$validfrom = $_POST['validfrom'];
$validto = $_POST['validto'];
$customerID = $_POST['customer'];
$repID = $_POST['rep'];

$date = date('Y-m-d');

$customerarray = array();
$totalAmount = 0;

$sql = "SELECT `u`.`idtbl_invoice`, `u`.`total`, `u`.`date`, `uc`.`name` AS `cusname`, `ue`.`name` AS `repname`
        FROM `tbl_invoice` AS `u`
        LEFT JOIN `tbl_customer` AS `uc` ON `u`.`tbl_customer_idtbl_customer` = `uc`.`idtbl_customer`
        LEFT JOIN `tbl_employee` AS `ue` ON `u`.`ref_id` = `ue`.`idtbl_employee`
        WHERE `u`.`status`=1 
        AND `u`.`paymentcomplete`=0 
        AND `u`.`date` BETWEEN '$validfrom' AND '$validto'";

if ($customerID > 0) {
    $sql .= " AND `u`.`tbl_customer_idtbl_customer` = '$customerID'";
}
if ($repID > 0) {
    $sql .= " AND `u`.`ref_id` = '$repID'";
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
}

$html = '<table class="table table-striped table-bordered table-sm small" id="outstandingReportTable">
    <thead>
        <tr>
            <th>Customer</th>
            <th>Rep</th>
            <th>Date</th>
            <th>Invoice</th>
            <th>Invoice Total</th>
        </tr>
    </thead>
    <tbody>';

foreach($customerarray as $rowcustomerarray) { 
    $html .= '<tr>
        <td>' . htmlspecialchars($rowcustomerarray['cusname']) . '</td>
        <td>' . htmlspecialchars($rowcustomerarray['repname']) . '</td>
        <td>' . htmlspecialchars($rowcustomerarray['date']) . '</td>
        <td>INV-' . htmlspecialchars($rowcustomerarray['idtbl_invoice']) . '</td>
        <td class="text-center">' . htmlspecialchars($rowcustomerarray['total']) . '</td>
    </tr>';
}

$html .= '</tbody>
    <tfoot>
        <tr>
            <td colspan="4" class="text-right"><strong>Total</strong></td>
            <td class="text-center"><strong>' . htmlspecialchars($totalAmount) . '</strong></td>
        </tr>
    </tfoot>
</table>';

echo $html;
?>
