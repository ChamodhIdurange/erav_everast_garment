<?php 
session_start();
require_once('../connection/db.php');

$fromdate = $_POST['fromdate'];
$todate = $_POST['todate'];
$today = date("Y-m-d");

$sqloutstanding =    "SELECT 
                    `e`.`name` AS 'empname',
                    `c`.`name` AS 'customername',
                    `c`.`address`,
                    `c`.`idtbl_customer`,
                    `co`.`date`,
                    `i`.`invoiceno`,
                    `i`.`nettotal`,
                    COALESCE((SELECT SUM(`r`.`payamount`) 
                            FROM tbl_invoice_payment_has_tbl_invoice r 
                            WHERE r.tbl_invoice_idtbl_invoice = i.idtbl_invoice), 0) AS payedamount


                FROM tbl_customer_order AS co
                LEFT JOIN tbl_employee AS e ON e.idtbl_employee = co.tbl_employee_idtbl_employee
                LEFT JOIN tbl_customer AS c ON c.idtbl_customer = co.tbl_customer_idtbl_customer
                LEFT JOIN tbl_invoice AS i ON i.tbl_customer_order_idtbl_customer_order = co.idtbl_customer_order
                WHERE co.status = '1'  
                AND co.date BETWEEN '$fromdate' AND '$todate'
                AND co.delivered = '1'
                ORDER BY `c`.`idtbl_customer` DESC";
$resultstock = $conn->query($sqloutstanding);

if ($resultstock->num_rows > 0) {
    $c=1;
    $customerId = -99;
    $oldCustomerId = -99;
    $netInvoiceAmount = 0;
    $netDeductions= 0;
    $netBalance = 0;
  
    echo '<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="margin: 0;">Customer Invoice Report</h2>
          </div>';
    while ($row = $resultstock->fetch_assoc()) {
        $c++;
        $customerId = $row['idtbl_customer'];
        // $oldCustomerId = $row['idtbl_customer'];

      

        if($c!=1 && $oldCustomerId != $customerId) {
            echo  '</tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-center"></td>
                        <td class="text-right"><strong>' . number_format($netInvoiceAmount, 2) . '</strong></td>
                        <td class="text-right"><strong>' . number_format($netDeductions, 2) . '</strong></td>
                        <td class="text-right"><strong>' . number_format($netBalance, 2) . '</strong></td>
                    </tr>
                </tfoot>
            </table>';

            $netInvoiceAmount = 0;
            $netDeductions= 0;
            $netBalance = 0;
            $c=1;
        }

        $netInvoiceAmount += $row['nettotal'];
        $netDeductions += $row['payedamount'];
        $netBalance += $row['nettotal'] - $row['payedamount'];

        if($oldCustomerId != $customerId ) {
            $oldCustomerId = $customerId;

            echo '<h3>'. $row['customername'] .'</h3><br><span>'. $row['address'] .'</spam>
                <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Invoice</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Rep Name</th>
                            <th class="text-center">Invoice Amount</th>
                            <th class="text-center">Deductions</th>
                            <th class="text-center">Balance</th>
                        </tr>
                    </thead>
                <tbody>';
        }
        echo '
                <tr>
                    <td class="text-center">' . $c . '</td>
                    <td class="text-center">' . $row['invoiceno'] . '</td>
                    <td class="text-center">' . $row['date'] . '</td>
                    <td class="text-center">' . $row['empname'] . '</td>
                    <td class="text-right">' . number_format($row['nettotal'], 2, '.', ',')  . '</td>
                    <td class="text-right">' . number_format($row['payedamount'], 2, '.', ',')  . '</td>
                    <td class="text-right">' . number_format($row['nettotal'] - $row['payedamount'], 2, '.', ',')  . '</td>
                </tr>';
        
    }
    echo  '</tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-center"></td>
                        <td class="text-right"><strong>' . number_format($netInvoiceAmount, 2) . '</strong></td>
                        <td class="text-right"><strong>' . number_format($netDeductions, 2) . '</strong></td>
                        <td class="text-right"><strong>' . number_format($netBalance, 2) . '</strong></td>
                    </tr>
                </tfoot>
            </table>';
} else {
    echo '<div class="alert alert-info" role="alert">No records found.</div>';
}
?>
