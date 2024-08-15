<?php 
require_once('../connection/db.php');

$validfrom = $_POST['validfrom'];
$validto = $_POST['validto'];
$accountID = $_POST['selectAccount'];

$sql = "SELECT `u`.`account`, `u`.`accountno`,`u`.`idtbl_account`,`ub`.`bankname`,`uc`.`amount`,`uc`.`narration` FROM `tbl_account` AS `u` 
        LEFT JOIN `tbl_bank` AS `ub` ON `u`.`tbl_bank_idtbl_bank`= `ub`.`idtbl_bank`
        LEFT JOIN `tbl_account_type` AS `ua` ON `u`.`tbl_account_type_idtbl_account_type`= `ua`.`idtbl_account_type`
        LEFT JOIN `tbl_pettycash_expenses` AS `uc` ON `u`.`idtbl_account`= `uc`.`tbl_account_petty_cash_account`
        WHERE DATE(`u`.`insertdatetime`) BETWEEN '$validfrom' AND '$validto'";

if ($accountID > 0) {
    $sql .= "AND `u`.`idtbl_account`='$accountID'";
}

$sql .= " GROUP BY `u`.`idtbl_account`";
$result = $conn->query($sql);


if ($result->num_rows == 0) {
    echo "<div style=\"color: red; font-size:20px;\">No Records</div>";
    return;
}

$html = '<table class="table table-striped table-bordered table-sm small" id="reportTable">
    <thead>
        <tr>
            <th>Account</th>
            <th class="text-center">Account No</th>
            <th class="text-center">Bank</th>
            <th class="text-center">Naration</th>
            <th class="text-center">Amount</th>
        </tr>
    </thead>
    <tbody>';

$totalAmount = 0;

while($row = $result->fetch_assoc()) {
    $html .= '<tr>
        <td>' . $row['account'] . '</td>
        <td class="text-center">' . $row['accountno'] . '</td>
        <td class="text-center">' . $row['bankname'] . '</td>
        <td class="text-center">' . $row['narration'] . '</td>
        <td class="text-center">' . number_format($row['amount'], 2) . '</td>
    </tr>';
    $totalAmount += $row['amount'];
}

$html .= '</tbody>
    <tfoot>
        <tr>
            <td colspan="4" class="text-center"><strong>Total</strong></td>
            <td class="text-center"><strong>' . number_format($totalAmount, 2) . '</strong></td>
        </tr>
    </tfoot>
</table>';

echo $html;
?>