<?php
session_start();
require_once('../connection/db.php');
require_once '../vendor/autoload.php'; // Adjust the path as necessary

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);

$dompdf = new Dompdf($options);

$paymentinoiceID=$_GET['paymentinoiceID'];

$sqlpaymentdetail="SELECT * FROM `tbl_invoice_payment_has_tbl_invoice` WHERE `tbl_invoice_payment_idtbl_invoice_payment`='$paymentinoiceID'";
$resultpaymentdetail=$conn->query($sqlpaymentdetail);

$sqlpaymentmethodscash="SELECT SUM(`i`.`amount`) as `payamount` FROM `tbl_invoice_payment_has_tbl_invoice` as `p` JOIN `tbl_invoice_payment` as `pi` on (`pi`.`idtbl_invoice_payment` = `p`.`tbl_invoice_payment_idtbl_invoice_payment`) JOIN `tbl_invoice_payment_detail` AS `i` ON (`i`.`tbl_invoice_payment_idtbl_invoice_payment` = `pi`.`idtbl_invoice_payment`) WHERE `pi`.`idtbl_invoice_payment`='$paymentinoiceID' AND `i`.`method` = '1'";
$resultpaymentmethodcash=$conn->query($sqlpaymentmethodscash);
$rowcash=$resultpaymentmethodcash->fetch_assoc();
$cashamount = $rowcash['payamount'];

$sqlpaymentmethodscheque="SELECT SUM(`i`.`amount`) as `payamount` FROM `tbl_invoice_payment_has_tbl_invoice` as `p` JOIN `tbl_invoice_payment` as `pi` on (`pi`.`idtbl_invoice_payment` = `p`.`tbl_invoice_payment_idtbl_invoice_payment`) JOIN `tbl_invoice_payment_detail` AS `i` ON (`i`.`tbl_invoice_payment_idtbl_invoice_payment` = `pi`.`idtbl_invoice_payment`) WHERE `pi`.`idtbl_invoice_payment`='$paymentinoiceID' AND `i`.`method` = '2'";
$resultpaymentmethodcheque=$conn->query($sqlpaymentmethodscheque);
$rowcheque=$resultpaymentmethodcheque->fetch_assoc();
$chequeamount = $rowcheque['payamount'];

$sqlpayment="SELECT * FROM `tbl_invoice_payment` WHERE `idtbl_invoice_payment`='$paymentinoiceID' AND `status`=1";
$resultpayment=$conn->query($sqlpayment);
$rowpayment=$resultpayment->fetch_assoc();

$sqlpaymentbank="SELECT * FROM `tbl_invoice_payment_detail` WHERE `status`=1 AND `tbl_invoice_payment_idtbl_invoice_payment`='$paymentinoiceID'";
$resultpaymentbank=$conn->query($sqlpaymentbank);

$html = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>EVEREST Hardware Co</title>
        <style>
            body {
                margin: 0;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans",
                    sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                line-height: 1.5;
            }
            .tg  {border-collapse:collapse;border-spacing:0;}
            .tg td{font-family:Arial, sans-serif;font-size:14px;padding:5px 10px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
            .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:5px 10px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
            .tg .tg-btmp{font-weight:bold;color:#000;text-align:left;vertical-align:top}
            .tg .tg-0lax{text-align:left;vertical-align:top}

            .receipt-header {
                font-family: Arial, sans-serif;
                margin-bottom: 20px;
                text-align: right; /* Center text for h4 and p */
                position: relative; /* Allows absolute positioning of the head-label */
            }

            .head-label {
                background-color: #000;
                color: #FFF;
                padding: 5px 15px;
                border-radius: 5px;
                width: 160px;
                text-align: center;
                position: absolute; /* Position relative to .receipt-header */
                top: -30px; /* Move up to be above h4 */
                right: 0; /* Align to the right edge */
            }

            h4 {
                margin: 30px 0 0; /* Adjust top margin to clear the label */
                font-weight: bold;
            }

            p {
                margin: 0;
                line-height: 1.5;
            }
        </style>
    </head>
    <body>
        <table border="0" width="100%">
            <tr>
                <td style="vertical-align: bottom;padding-bottom: 17px;">Receipt: PR-'.$paymentinoiceID.'</td>
                <td style="text-align: right;">
                    <div class="receipt-header">
                        <div class="header-content">
                            <div class="head-label">PAYMENT RECEIPT</div>
                        </div>
                        <h4>Everest Hardware (Pvt) Ltd Test</h4>
                        <p>
                            Head Office : No.J174/20, Araliya Uyana, Kegalla.<br>
                            Branch : No.107, Paragammana, Kegalla.<br>
                            Tel: 0094-35-2232924 | Fax: 0094-77-9001546<br>
                            support@everesthardware.com
                        </p>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <hr style="border-color: #000;margin-top:5px; margin-bottom:5px;">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table class="tg" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice No</th>
                                <th style="text-align: right">Invoice Amount</th>
                                <th style="text-align: right">Discount</th>
                                <th style="text-align: right">Payment</th>
                            </tr>
                        </thead>
                        <tbody>';
                            $i=1;while($rowpaymentdetails=$resultpaymentdetail->fetch_assoc()){
                            $html.='<tr>
                                <td>'.$i.'</td>
                                <td>INV-'.$rowpaymentdetails['tbl_invoice_idtbl_invoice'].'</td>
                                <td style="text-align: right">';
                                    $invoiceID=$rowpaymentdetails['tbl_invoice_idtbl_invoice']; $sqlinvoice="SELECT `total` FROM `tbl_invoice` WHERE `idtbl_invoice`='$invoiceID' AND `status`=1"; 
                                    $resultinvoice=$conn->query($sqlinvoice); 
                                    $rowinvoice=$resultinvoice->fetch_assoc();

                                    $html.=number_format($rowinvoice['total'], 2);
                                $html.='</td>
                                <td style="text-align: right">'.number_format($rowpaymentdetails['discount'],2).'</td>
                                <td style="text-align: right">';$paymentdone = $rowinvoice['total'] - $rowpaymentdetails['discount']; $html.=number_format($paymentdone,2).'</td>
                            </tr>';
                            $i++;}
                        $html.='</tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="50%" style="vertical-align: top;">
                    <div style="margin-bottom: 15px; margin-top: 15px;">Payment Methods</div>
                    <table class="tg" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-right">Method</th>
                                <th style="text-align: right">Payment</th>
                            </tr>
                        </thead>
                        <tbody>'; 
                            while($rowpaymentbank=$resultpaymentbank->fetch_assoc()){
                            $html.='<tr>
                                <td>';if($rowpaymentbank['method']==1){$html.='Cash';}else if($rowpaymentbank['method']==2){$html.='Cheque';}else if($rowpaymentbank['method']==3){$html.='Credit Note';}$html.='</td>
                                <td style="text-align: right">'.number_format($rowpaymentbank['amount'], 2).'</td>
                            </tr>';
                            }
                        $html.='<tbody>
                    </table>
                </td>
                <td style="vertical-align: top;">
                    <table width="100%">
                        <tr>
                            <td width="65%" style="text-align: right">Net Total</td>
                            <td style="text-align: right">Rs. '.number_format($rowpayment['payment'], 2).'</td>
                        </tr>
                        <tr>
                            <td width="65%" style="text-align: right">Payment</td>
                            <td style="text-align: right">Rs. '.number_format($rowpayment['payment'], 2).'</td>
                        </tr>
                        <tr>
                            <td width="65%" style="text-align: right">Balance</td>
                            <td style="text-align: right">Rs. '.number_format($rowpayment['balance'], 2).'</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>';
// echo $html;
$dompdf->loadHtml($html);
// $dompdf->setPaper('21.5cm', '27.5cm', 'portrait');
$dompdf->render();
$dompdf->stream("Test.pdf", ["Attachment" => 0]);
