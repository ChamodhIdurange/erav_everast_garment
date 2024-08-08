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

$sqlpoprinted="UPDATE `tbl_customer_order` SET `is_printed`='1' WHERE `idtbl_customer_order`='$recordID'";
$conn->query($sqlpoprinted);

$sqlporderinfo = "SELECT `o`.`idtbl_customer_order`, `o`.`date`, `o`.`total`, `l`.`idtbl_locations`, `l`.`locationname`, `c`.`name`, `c`.`address`, `c`.`phone`, `e`.`name` AS `saleref`, `e`.`phone`, `a`.`area`, `u`.`name` as `username`, `o`.`tbl_customer_idtbl_customer`, `o`.`cuspono` FROM `tbl_customer_order` AS `o` LEFT JOIN `tbl_customer_order_detail` AS `od` ON `o`.`idtbl_customer_order`=`od`.`tbl_customer_order_idtbl_customer_order` LEFT JOIN `tbl_customer` AS `c` ON (`c`.`idtbl_customer` = `o`.`tbl_customer_idtbl_customer`) LEFT JOIN `tbl_locations` AS `l` ON (`l`.`idtbl_locations` = `o`.`tbl_locations_idtbl_locations`) LEFT JOIN `tbl_employee` AS `e` ON `e`.`idtbl_employee`=`o`.`tbl_employee_idtbl_employee` LEFT JOIN `tbl_area` AS `a` ON `a`.`idtbl_area`=`o`.`tbl_area_idtbl_area` LEFT JOIN `tbl_user` AS `u` ON `u`.`idtbl_user`=`o`.`tbl_user_idtbl_user` WHERE `o`.`status`=1 AND `o`.`idtbl_customer_order`='$recordID'";
$resultporderinfo = $conn->query($sqlporderinfo);
$rowporderinfo = $resultporderinfo->fetch_assoc();

$customerID = $rowporderinfo['tbl_customer_idtbl_customer'];
$customerPhone = $rowporderinfo['phone'];
$customername = $rowporderinfo['name'];
$location = $rowporderinfo['locationname'];
$customeraddress = $rowporderinfo['address'];
$poderId = $rowporderinfo['idtbl_customer_order'];


$sqlporderdetail = "SELECT `p`.`product_name`, `p`.`idtbl_product`, `d`.`qty`, `d`.`saleprice` FROM `tbl_customer_order_detail` AS `d` LEFT JOIN `tbl_product` AS `p` ON `p`.`idtbl_product`=`d`.`tbl_product_idtbl_product` WHERE `d`.`tbl_customer_order_idtbl_customer_order`='$recordID' AND `d`.`status`=1";
$resultporderdetail = $conn->query($sqlporderdetail);

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
                        <tr><td width="53%" height="0.5cm"> </td><td align="left">Date: ' . $today . ' </td></tr>
                        <tr><td height="0.5cm"></td> <td align="left">PO Number: ' . $poderId . '</td></tr>
                        <tr><td height="0.5cm"></td> <td align="left">Location: '.$location.'</td></tr>
                        <tr><td height="0.5cm"></td> <td align="left">Employee: ' . $rowporderinfo['saleref'] . '</td></tr>
                        <tr><td height="0.5cm"></td> <td align="left">Contact: ' . $rowporderinfo['phone'] . '</td></tr>
                    </table>
                </td>
            </tr>
        </table>
    </header>

    <main>
        <div class="">
            <table width="100%" style="padding-left:1cm; padding-right:1cm; padding-top:0.2cm;">
            ';
            $rowCount = mysqli_num_rows($resultporderdetail);
            $count = 0;
            $count1 = 0;

            while ($rowporderdetail = $resultporderdetail->fetch_assoc()) {
                $totnew = $rowporderdetail['qty'] * $rowporderdetail['saleprice'];
                $fulltot += $totnew;
                $count = $count + 1;
                $count1++;
                $html .= '
                    <tr>
                        <td style="width:2cm;">' . $rowporderdetail['idtbl_product'] . '</td>
                        <td style="width:8.5cm;">' . $rowporderdetail['product_name'] . '</td>
                        <td style="width:1.5cm;" align="center">' . $rowporderdetail['qty'] . '</td>
                        <td style="width:2.5cm;" align="right">' . number_format($rowporderdetail['saleprice'], 2) . '</td>
                        <td style="width:1.3cm;" align="right">0.00</td>
                        <td style="width:2.6cm;" align="right">' . number_format(($rowporderdetail['saleprice'] * $rowporderdetail['qty']), 2) . '</td>
                    </tr>
                ';
                $temptotal = $rowporderdetail['qty'] * $rowporderdetail['saleprice'];
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
            $discount = $fulltot - $rowporderinfo['total'];
            $html .= '
            </table> 
            ';

            if ($resultporderdetail->num_rows == $count) {
                $html .= '
                    <footer>
                        <div style="margin-right: -1.7cm; padding-right: 2.5cm;">
                            <table width="100%" height="100%" style="border-collapse: collapse;" border="0">
                            ';
                                $discount = $fulltot - $rowporderinfo["total"];
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
