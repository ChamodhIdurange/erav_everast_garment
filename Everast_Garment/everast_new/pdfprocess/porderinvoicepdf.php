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

$today = date('Y-m-d');
$today2 = date('Y/m');
$last_two_digits = substr($today2, 2);
$recordID = $_GET['id'];

$empty = 'null';
$fulltot = 0;
$discount = 0;
$totaloutstanding = 0;
$fulloutstanding = 0;
$totalpayment = 0;
$net_total = 0;
$newtemp = 0;

$sqlinvoiceinfo = "SELECT `tbl_customer_order`.`discount`, `tbl_customer_order`.`idtbl_customer_order`, `tbl_customer_order`.`cuspono`, `tbl_customer_order`.`date`, `tbl_customer_order`.`total`, `tbl_locations`.`idtbl_locations`, `tbl_locations`.`locationname`, `tbl_customer`.`name`, `tbl_customer`.`address`, `tbl_customer`.`phone` AS 'customerphone' , `tbl_employee`.`name` AS `saleref`, `tbl_employee`.`phone` AS 'salesrepphone', `tbl_area`.`area`, `tbl_user`.`name` as `username`, `tbl_customer_order`.`tbl_customer_idtbl_customer`, `tbl_customer_order`.`cuspono` FROM `tbl_customer_order` LEFT JOIN `tbl_locations` ON `tbl_locations`.`idtbl_locations`=`tbl_customer_order`.`tbl_locations_idtbl_locations` LEFT JOIN `tbl_customer` ON `tbl_customer`.`idtbl_customer`=`tbl_customer_order`.`tbl_customer_idtbl_customer` LEFT JOIN `tbl_employee` ON `tbl_employee`.`idtbl_employee`=`tbl_customer_order`.`tbl_employee_idtbl_employee` LEFT JOIN `tbl_area` ON `tbl_area`.`idtbl_area`=`tbl_customer_order`.`tbl_area_idtbl_area` LEFT JOIN `tbl_user` ON `tbl_user`.`idtbl_user`=`tbl_customer_order`.`tbl_user_idtbl_user`WHERE `tbl_customer_order`.`status`=1 AND `tbl_customer_order`.`idtbl_customer_order`='$recordID'";

$resultinvoiceinfo = $conn->query($sqlinvoiceinfo);
$rowinvoiceinfo = $resultinvoiceinfo->fetch_assoc();

$customerID = $rowinvoiceinfo['tbl_customer_idtbl_customer'];
$customerPhone = $rowinvoiceinfo['customerphone'];
$salesrepPhone = $rowinvoiceinfo['salesrepphone'];
$customername = $rowinvoiceinfo['name'];
$location = $rowinvoiceinfo['locationname'];
$customeraddress = $rowinvoiceinfo['address'];
// $invoID = $rowinvoiceinfo['idtbl_invoice'];
$cuspono = $rowinvoiceinfo['cuspono']; 
$pono = $rowinvoiceinfo['cuspono']; 
$porderDate = $rowinvoiceinfo['date']; 
$cusPorderId = $rowinvoiceinfo['idtbl_customer_order']; 


// $sqlpoID = "SELECT `idtbl_porder_invoice` FROM `tbl_porder_invoice` WHERE `tbl_customer_order_idtbl_customer_order` = '$invoID'";
// $resultpoID = $conn->query($sqlpoID);
// $rowpoID = $resultpoID->fetch_assoc();

$sqlinvoicedetail = "SELECT `tbl_product`.`product_name`, `tbl_product`.`product_code`, `tbl_product`.`idtbl_product`, `tbl_customer_order_detail`.`qty`, `tbl_customer_order_detail`.`saleprice` FROM `tbl_customer_order_detail` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_customer_order_detail`.`tbl_product_idtbl_product` WHERE `tbl_customer_order_detail`.`tbl_customer_order_idtbl_customer_order`='$recordID' AND `tbl_customer_order_detail`.`status`=1";
$resultinvoicedetail = $conn->query($sqlinvoicedetail);



$html = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>EVEREST Hardware Co</title>
        <style>
            *{
                font-size: 10;
                margin:0.2px;
                font-family: \'San-Serif\', sans-serif;
            }
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height:6cm;
            }
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0.3cm;
                bottom: 7cm;
            }
            .leftboxtop{
                width:10.5cm;
                height:4.25cm;
            }
            .bottomtop{
                width:2.5cm;
            }
            .righttop{
                width:7.5cm;
            }
            .bottomtable{
                height:13.5cm;
            }
            .divclass{
                border-right:1px solid black;
            }
        </style>
    </head>
    <body style="margin-top:7cm; margin-bottom:5cm; height:14cm">

    <header>
        <table border="0" width="100%">
            <tr>
                <td colspan="3" height="1.8cm"></td>
            </tr>
            <tr>
                <td class="leftboxtop" width="10cm">
                    <table border="0" width="100%" style="margin-top:-43; padding-left:0.3cm;">
                        <tr>
                            <td>Customer ID : ' . $customerID . '<br>' . $customername . '<br>' . $customeraddress . '<br>Tel : ' . $customerPhone . '</td>
                        </tr>
                    </table>
                </td>
                <td width="3cm">&nbsp;</td>
                <td>
                    <table width="100%" height="100%" border="0">
                        <tr><td width="53%" height="0.5cm"> </td><td align="left">' . $porderDate . ' </td></tr>
                        <tr><td height="0.5cm"></td> <td align="left">' . $cusPorderId . '</td></tr>
                        <tr><td height="0.5cm"></td> <td align="left">' . $cuspono . '</td></tr>
                        <tr><td height="0.5cm"></td> <td align="left">'.$location.'</td></tr>
                        <tr><td height="0.5cm"></td> <td align="left">' . $rowinvoiceinfo['saleref'] . '</td></tr>
                        <tr><td height="0.5cm"></td> <td align="left">' . $salesrepPhone. '</td></tr>
                    </table>
                </td>
            </tr>
        </table>
    </header>

    <main>
        <div class="">
            <table width="100%" style="padding-left:1cm; padding-right:1cm; padding-top:0.2cm;">
            ';
            $rowCount = mysqli_num_rows($resultinvoicedetail);
            $count = 0;
            $count1 = 0;

            while ($rowinvoicedetail = $resultinvoicedetail->fetch_assoc()) {
                $totnew = $rowinvoicedetail['qty'] * $rowinvoicedetail['saleprice'];
                $fulltot += $totnew;
                $count = $count + 1;
                $count1++;
                $html .= '
                    <tr>
                        <td style="width:2cm;">' . $rowinvoicedetail['idtbl_product'] . '</td>
                        <td style="width:5.0cm;">' . $rowinvoicedetail['product_name'] . '</td>
                        <td style="width:3.5cm;">' . $rowinvoicedetail['product_code'] . '</td>
                        <td style="width:1.5cm;" align="center">' . $rowinvoicedetail['qty'] . '</td>
                        <td style="width:2.5cm;" align="right">' . number_format($rowinvoicedetail['saleprice'], 2) . '</td>
                        <td style="width:1.3cm;" align="right">0.00</td>
                        <td style="width:2.6cm;" align="right">' . number_format(($rowinvoicedetail['saleprice'] * $rowinvoicedetail['qty']), 2) . '</td>
                    </tr>
                ';
                $temptotal = $rowinvoicedetail['qty'] * $rowinvoicedetail['saleprice'];
                $newtemp += $temptotal;
                if ($count1 % 28 == 0) {
                    $html .= '
                        <tr>
                            <td colspan="5">This page Total Showing here. See the Next page Thank You</td>
                            <td style="width:2.6cm;" align="right">' . number_format($newtemp, 2) . '</td>
                        </tr>
                    ';
                    $newtemp = 0;
                }
            }
            $html .= '
            </table> 
            ';

            if ($resultinvoicedetail->num_rows == $count) {
                $html .= '
                    <footer>
                        <div style="margin-right: -1.7cm; padding-right: 2.5cm;">
                            <table width="100%" height="100%" style="border-collapse: collapse;" border="0">
                            ';
                                $discount = $rowinvoiceinfo["discount"];
                                $net_total = $fulltot - $discount;

                                $html .= '
                                <tr>
                                    <td align="right">' . number_format($fulltot, 2) . '</td>
                                </tr>
                                <tr>
                                    <td align="right" style="padding-top:0.2cm;">' . number_format($discount, 2) . '</td>
                                </tr>
                                <tr>
                                    <td align="right" style="padding-top:0.2cm;">' . number_format($net_total, 2) . '</td>
                                </tr>
                            </table>
                        </div>
                    </footer>';
            }
            $html .= '  
        </div>
        
    </main>
    </body>
    </html>';

$dompdf->loadHtml($html);
$dompdf->setPaper('21.5cm', '27.5cm', 'portrait');
$dompdf->render();
$dompdf->stream("Test.pdf", ["Attachment" => 0]);
