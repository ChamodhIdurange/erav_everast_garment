<?php
include "../connection/db.php"; 
require_once '../vendor/autoload.php';
use Dompdf\Dompdf;

$item = $_GET['item'] ?? null;
if (!$item) {
    die("No product selected.");
}

$sql_product = $conn->prepare("SELECT product_name FROM tbl_product WHERE idtbl_product=?");
$sql_product->bind_param("i", $item);
$sql_product->execute();
$res_product = $sql_product->get_result();
$product_name = $res_product->fetch_assoc()['product_name'] ?? 'Unknown Product';

$sql_monthend = $conn->prepare("
    SELECT date, qty as opening_balance 
    FROM tbl_month_end 
    WHERE tbl_product_idtbl_product=? 
    ORDER BY date DESC LIMIT 1
");
$sql_monthend->bind_param("i", $item);
$sql_monthend->execute();
$res_monthend = $sql_monthend->get_result();
$monthend = $res_monthend->fetch_assoc();
$opening_balance = $monthend['opening_balance'] ?? 0;
$end_date = $monthend['date'] ?? date('Y-m-d');

$transactions = [];

$sql_in = $conn->prepare("
    SELECT r.returndate as date, rd.qty as qty, 'IN' as type, 
           CONCAT('Return #', r.idtbl_return) as reference,
           c.name as customer
    FROM tbl_return_details rd
    INNER JOIN tbl_return r ON rd.tbl_return_idtbl_return = r.idtbl_return
    LEFT JOIN tbl_customer c ON r.tbl_customer_idtbl_customer = c.idtbl_customer
    WHERE rd.tbl_product_idtbl_product = ? AND r.status=1 AND r.returndate <= ?
");
$sql_in->bind_param("is", $item, $end_date);
$sql_in->execute();
$res_in = $sql_in->get_result();
while ($row = $res_in->fetch_assoc()) {
    $transactions[] = $row;
}

$sql_out = $conn->prepare("
    SELECT i.date as date, id.qty as qty, 'OUT' as type, 
           CONCAT('Invoice #', i.idtbl_invoice) as reference,
           c.name as customer
    FROM tbl_invoice_detail id
    INNER JOIN tbl_invoice i ON id.tbl_invoice_idtbl_invoice = i.idtbl_invoice
    LEFT JOIN tbl_customer c ON i.tbl_customer_idtbl_customer = c.idtbl_customer
    WHERE id.tbl_product_idtbl_product = ? AND i.date <= ?
");
$sql_out->bind_param("is", $item, $end_date);
$sql_out->execute();
$res_out = $sql_out->get_result();
while ($row = $res_out->fetch_assoc()) {
    $transactions[] = $row;
}

usort($transactions, function ($a, $b) {
    return strtotime($a['date']) - strtotime($b['date']);
});

$html = '
<p style="font-weight:bold;font-size:20px;">EVEREST HARDWARE CO. (PVT) LTD;</p>
<p style="font-weight:bold;">#363/10/01, Malwatte, Kal-Eliya (Mirigama).</p>
<p style="font-weight:bold;">033 4 950 951</p>
<p style="font-weight:bold;">everest.hardware@yahoo.com</p><br>

<h3 style="text-align:center;">BIN Report - ' . $product_name . '</h3>
<p style="text-align:center;">Up to: ' . $end_date . '</p>
<table border="1" cellpadding="5" cellspacing="0" width="100%" style="border-collapse:collapse;">
    <thead>
        <tr style="background:#ddd;">
            <th>Date</th>
            <th>Reference</th>
            <th>Customer</th>
            <th>In Qty</th>
            <th>Out Qty</th>
            <th>Balance</th>
        </tr>
    </thead>
    <tbody>';

$balance = $opening_balance;
$html .= '<tr style="background:#f0f0f0;font-weight:bold;">
            <td colspan="5">Opening Balance</td>
            <td>' . $balance . '</td>
          </tr>';

foreach ($transactions as $tr) {
    if ($tr['type'] == 'IN') {
        $balance += $tr['qty'];
        $inQty = $tr['qty'];
        $outQty = '-';
    } else {
        $balance -= $tr['qty'];
        $inQty = '-';
        $outQty = $tr['qty'];
    }
    $customer = $tr['customer'] ?? '-';
    $html .= '<tr>
                <td>' . $tr['date'] . '</td>
                <td>' . $tr['reference'] . '</td>
                <td>' . $customer . '</td>
                <td>' . $inQty . '</td>
                <td>' . $outQty . '</td>
                <td>' . $balance . '</td>
              </tr>';
}

$html .= '</tbody></table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("BIN_Report_{$product_name}.pdf", ["Attachment" => 0]);
