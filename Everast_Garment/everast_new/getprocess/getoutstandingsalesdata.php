<?php 
session_start();
require_once('../connection/db.php');

$fromdate = $_POST['fromdate'];
$todate = $_POST['todate'];
$replist = $_POST['replist'];
$replist = implode(", ", $replist);

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
                AND co.tbl_employee_idtbl_employee IN ($replist)
                AND i.paymentcomplete = '0'
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
            <div style="text-align: left;">
                <h4 style="margin: 0;">EVEREST HARDWARE CO. (PVT) LTD</h4>
                <p style="margin: 5px 0; font-size: 14px;">
                    #363/10/01, Malwatte, Kal-Eliya (Mirigama) <br>
                    033 4 950 951 | <a href="mailto:info&everesthardware.lk">info&everesthardware.lk</a>
                </p>
            </div>
            <div>
                <h2 style="margin: 0;">Customer Outstanding Report</h2>
            </div>
        </div>';
        while ($row = $resultstock->fetch_assoc()) {
            $customerId = $row['idtbl_customer'];
        
            if ($c != 1 && $oldCustomerId != $customerId) {
                echo '
                        </tbody>
                            <tfoot>
                                <tr style="background-color: #f1f1f1; font-weight: bold;">
                                    <td colspan="4" class="text-center">Total</td>
                                    <td class="text-right">' . number_format($netInvoiceAmount, 2) . '</td>
                                    <td class="text-right">' . number_format($netDeductions, 2) . '</td>
                                    <td class="text-right">' . number_format($netBalance, 2) . '</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>';
        
                $netInvoiceAmount = 0;
                $netDeductions = 0;
                $netBalance = 0;
                $c = 1;
            }
        
            $netInvoiceAmount += $row['nettotal'];
            $netDeductions += $row['payedamount'];
            $netBalance += $row['nettotal'] - $row['payedamount'];
        
            if ($oldCustomerId != $customerId) {
                $oldCustomerId = $customerId;
        
                echo '
                   <div style="background: #fff; border-radius: 10px; box-shadow: 0px 3px 8px rgba(0,0,0,0.1); padding: 15px; margin-bottom: 20px; border-left: 5px solid #004085;">
                    <h2 style="margin: 0; font-weight: bold; color: #004085;">' . $row['customername'] . '</h2>
                    <p style="margin: 3px 0 12px; font-size: 13px; color: #666;">' . $row['address'] . '</p>

                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable" style="background: #fff; border-radius: 5px; overflow: hidden;">
                        <thead style="background: #004085; color: #fff;">
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
                <tr style="">
                <td class="text-center">' . $c . '</td>
                <td class="text-center">' . $row['invoiceno'] . '</td>
                <td class="text-center">' . $row['date'] . '</td>
                <td class="text-center">' . $row['empname'] . '</td>
                <td class="text-right">' . number_format($row['nettotal'], 2, '.', ',') . '</td>
                <td class="text-right">' . number_format($row['payedamount'], 2, '.', ',') . '</td>
                <td class="text-right">' . number_format($row['nettotal'] - $row['payedamount'], 2, '.', ',') . '</td>
        </tr>';
            $c++;
        }
        
        echo '
            </tbody>
        <tfoot>
            <tr style="background-color: #f1f1f1; font-weight: bold;">
                <td colspan="4" class="text-center">Total</td>
                <td class="text-right">' . number_format($netInvoiceAmount, 2) . '</td>
                <td class="text-right">' . number_format($netDeductions, 2) . '</td>
                <td class="text-right">' . number_format($netBalance, 2) . '</td>
            </tr>
        </tfoot>
    </table>
</div>';
} else {
    echo '<div class="alert alert-info" role="alert">No records found.</div>';
}
?>

