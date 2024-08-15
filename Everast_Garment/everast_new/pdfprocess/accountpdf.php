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
$accountID = $_GET['selectedAccount'];
$searchType = $_GET['searchType'];

$sqlinfo = "SELECT `u`.`account`, `u`.`accountno`,`u`.`idtbl_account`,`ub`.`bankname`,`uc`.`amount`,`uc`.`narration` FROM `tbl_account` AS `u` 
        LEFT JOIN `tbl_bank` AS `ub` ON `u`.`tbl_bank_idtbl_bank`= `ub`.`idtbl_bank`
        LEFT JOIN `tbl_account_type` AS `ua` ON `u`.`tbl_account_type_idtbl_account_type`= `ua`.`idtbl_account_type`
        LEFT JOIN `tbl_pettycash_expenses` AS `uc` ON `u`.`idtbl_account`= `uc`.`tbl_account_petty_cash_account`
        WHERE DATE(`u`.`insertdatetime`) BETWEEN '$validfrom' AND '$validto'";


if ($searchType == '2') { 
    if ($accountID > 0) {
        $sqlinfo .= " AND `u`.`idtbl_account`='$accountID'";
    }
} 

$sqlinfo .= " GROUP BY `u`.`idtbl_account`";

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
            <p>Accounts Report';
    
    if ($searchType == 2) {
        $html .= ' - Account Wise';
    } else {
        $html .= ' - All';
    }
    
    $html .= '</p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h4 class="text-center">Sales Report Filtered from ' . $validfrom . ' to ' . $validto . '</h4>
            <hr class="border-dark">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <table class="tablec">
                <thead>
                    <tr>
                        <th class="thc">Account</th>
                        <th class="thc">Account No</th>
                        <th class="thc">Bank</th>
                        <th class="thc">Naration</th>
                        <th class="thc">Amount</th>
                    </tr>  
                </thead>
                <tbody>';

    $totalAmount = 0;
    while ($rowsqlinfo =     $resultsqlinfo->fetch_assoc()) {
        $html .= '
        <tr>
            <td class="tdc">' . $rowsqlinfo['account'] . '</td> 
            <td class="tdc">' . $rowsqlinfo['accountno'] . '</td> 
            <td class="tdc">' . $rowsqlinfo['bankname'] . '</td>
            <td class="tdc">' . $rowsqlinfo['narration'] . '</td>
            <td class="tdc">' . number_format($rowsqlinfo['amount'], 2) . '</td>
        </tr>';
        $totalAmount += $rowsqlinfo['amount'];
    }

    $html .= '
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="thc"><strong>Total</strong></td>
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
    $dompdf->stream("Sales_Report.pdf", ["Attachment" => 0]);

} else {
    echo "No records found for the selected date range.";
}
?>

