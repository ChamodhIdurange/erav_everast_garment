<?php
session_start();
require_once('../connection/db.php');
require_once '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);

$dompdf = new Dompdf($options);

$validfrom = $_GET['validfrom'];
$validto = $_GET['validto'];
$searchType = intval($_GET['searchType']);
$customer = intval($_GET['customer']);
$rep = intval($_GET['rep']);


$sqlinfo = "SELECT `u`.`idtbl_invoice`,`u`.`invoiceno`, `u`.`total`, `u`.`date`, `uc`.`name` AS `cusname`, `ue`.`name` AS `repname`
        FROM `tbl_invoice` AS `u`
        LEFT JOIN `tbl_customer` AS `uc` ON `u`.`tbl_customer_idtbl_customer` = `uc`.`idtbl_customer`
        LEFT JOIN `tbl_customer_order` AS `ud` ON `u`.`tbl_customer_order_idtbl_customer_order` = `ud`.`idtbl_customer_order`
        LEFT JOIN `tbl_employee` AS `ue` ON `ud`.`tbl_employee_idtbl_employee` = `ue`.`idtbl_employee`
        WHERE `u`.`status`=1 
        AND `u`.`paymentcomplete`=0 
        AND `u`.`date` BETWEEN '$validfrom' AND '$validto'";


if ($searchType == 3 && $customer > 0) { 
    $sqlinfo .= " AND `u`.`tbl_customer_idtbl_customer` = '$customer'";
}

if ($searchType == 2 && $rep > 0) { 
    $sqlinfo .= " AND `ue`.`idtbl_employee` = '$rep'";
}

$sqlinfo .= " GROUP BY `u`.`idtbl_invoice`";

$resultsqlinfo = $conn->query($sqlinfo);

if ($resultsqlinfo->num_rows > 0) {
    $html = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sales Report</title>
        <style>
            @page {
                margin-top: 5px;
            }
            body {
                margin: 0px;
                padding: 0px;
                font-family: Arial, sans-serif;
                width: 100%;
                font-size: small;
            }
            .tablec {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
                font-size: 10px;
                border: 1px solid #ddd;
            }
            .thc, .tdc {
                padding: 5px;
                text-align: center;
            }
            .thc {
                background-color: #f2f2f2;
            }
            .tdc {
                border: 1px solid #ddd;
            }
        </style>
    </head>
    <body>
    <div class="row">
        <div class="col-12">
            <table class="w-100 tableprint">
                <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td><strong>EVEREST HARDWARE PRIVATE LIMITED.</strong><br>
                            363/10/01, Malwatta, Kal-Eliya, Mirigama.<br>
                            Tel: 033 4 950 951, Mobile: 0772710710, FAX: 0372221580<br>
                            <strong>E-Mail: info@everesthardware.lk  Web: www.everesthardware.lk</strong></td>
                        <td>&nbsp;</td>
                    </tr>
                </tbody>            
            </table>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <p>Outstanding Report';
    
    if ($searchType == 3) {
        $html .= ' - Customer Wise';
    } elseif ($searchType == 2) {
        $html .= ' - Rep Wise';
    } else {
        $html .= ' - All';
    }
    
    $html .= '</p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h4 class="text-center">Outstanding Report Filtered By ' . $validfrom . ' to ' . $validto . '</h4>
            <hr class="border-dark">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <table class="tablec">
                <thead>
                    <tr>
                        <th class="thc">Customer</th>
                        <th class="thc">Rep</th>
                        <th class="thc">Date</th>
                        <th class="thc">Days</th>
                        <th class="thc">Invoice</th>
                        <th class="thc">Invoice Total</th>
                    </tr>  
                </thead>
                <tbody>';

    $totalAmount = 0;
    while ($rowsqlinfo = $resultsqlinfo->fetch_assoc()) {

        $date = new DateTime($rowsqlinfo['date']);
        $today = new DateTime();  
        $interval = $today->diff($date);  
        $datecount = $interval->days;  

        $html .= '
        <tr>
            <td class="tdc">' . $rowsqlinfo['cusname'] . '</td> 
            <td class="tdc">' . $rowsqlinfo['repname'] . '</td> 
            <td class="tdc">' . $rowsqlinfo['date'] . '</td> 
            <td class="tdc">DAYS ' . $datecount . '</td>
            <td class="tdc">' . $rowsqlinfo['invoiceno'] . '</td>
            <td class="tdc">' . number_format($rowsqlinfo['total'], 2) . '</td>
        </tr>';
        $totalAmount += $rowsqlinfo['total'];
    }

    $html .= '
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="thc"><strong>Total</strong></td>
                        <td class="thc"><strong>' . number_format($totalAmount, 2) . '</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    </body>
    </html>';

    $dompdf->loadHtml($html); 
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("Outstanding_Report.pdf", ["Attachment" => 0]);

} else {
    echo "No records found for the selected date range.";
}
?>