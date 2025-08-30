<?php
include "../connection/db.php";
require_once '../vendor/autoload.php';

use Dompdf\Dompdf;

$item      = $_GET['item']      ?? null;
$frommonth = $_GET['frommonth'] ?? null;
$tomonth   = $_GET['tomonth']   ?? null;

if (!$item || !$frommonth || !$tomonth) {
    die("Missing filters");
}

// -------------------------------
// 1. Convert months to full dates
// -------------------------------
$fromdate = $frommonth . "-01"; // e.g. 2025-04 → 2025-04-01

// -------------------------------
// 2. Get product name
// -------------------------------
$sql_product = $conn->prepare("SELECT product_name FROM tbl_product WHERE idtbl_product=?");
$sql_product->bind_param("i", $item);
$sql_product->execute();
$res_product = $sql_product->get_result();
$product_name = $res_product->fetch_assoc()['product_name'] ?? 'Unknown Product';

// -------------------------------
// 3. Opening Balance (from stock)
// -------------------------------
// -------------------------------
// 3. Opening Balance (first available in from-month)
// -------------------------------
$sql_opening = $conn->prepare("
    SELECT qty, `update`
    FROM tbl_stock 
    WHERE tbl_product_idtbl_product=? 
      AND DATE_FORMAT(`update`, '%Y-%m') = ?
    ORDER BY `update` ASC 
    LIMIT 1
");
$sql_opening->bind_param("is", $item, $frommonth);
$sql_opening->execute();
$res_opening = $sql_opening->get_result();
$row_opening = $res_opening->fetch_assoc();

if ($row_opening) {
    $fromdate         = $row_opening['update'];  // ✅ real first available date in that month
    $opening_balance  = $row_opening['qty'];
} else {
    // if no stock in that month, fallback to last qty before that month
    $sql_fallback = $conn->prepare("
        SELECT qty, `update`
        FROM tbl_stock 
        WHERE tbl_product_idtbl_product=? 
          AND `update` < ?
        ORDER BY `update` DESC 
        LIMIT 1
    ");
    $startMonthDate = $frommonth . "-01";
    $sql_fallback->bind_param("is", $item, $startMonthDate);
    $sql_fallback->execute();
    $res_fb = $sql_fallback->get_result();
    $row_fb = $res_fb->fetch_assoc();

    $fromdate        = $startMonthDate;                 // still use requested month start
    $opening_balance = $row_fb['qty'] ?? 0;             // last known balance before month
}


// -------------------------------
// 4. To Date (from tbl_month_end)
// -------------------------------
$sql_monthend = $conn->prepare("
    SELECT date 
    FROM tbl_month_end 
    WHERE tbl_product_idtbl_product=? 
      AND DATE_FORMAT(date, '%Y-%m') = ?
    ORDER BY date DESC LIMIT 1
");
$sql_monthend->bind_param("is", $item, $tomonth);
$sql_monthend->execute();
$res_monthend = $sql_monthend->get_result();
$row_monthend = $res_monthend->fetch_assoc();

if ($row_monthend) {
    $todate = $row_monthend['date'];   // ✅ real saved month-end date
} else {
    $todate = date("Y-m-t", strtotime($tomonth . "-01")); // fallback
}

// -------------------------------
// 5. Fetch transactions
// -------------------------------
$transactions = [];

// IN (Returns)
$sql_in = $conn->prepare("
    SELECT r.returndate as date, rd.qty as qty, 'IN' as type,
           CONCAT('Return #', r.idtbl_return) as reference,
           c.name as customer
    FROM tbl_return_details rd
    INNER JOIN tbl_return r ON rd.tbl_return_idtbl_return = r.idtbl_return
    LEFT JOIN tbl_customer c ON r.tbl_customer_idtbl_customer = c.idtbl_customer
    WHERE rd.tbl_product_idtbl_product=? AND r.status=1 
          AND r.returndate BETWEEN ? AND ?
");
$sql_in->bind_param("iss", $item, $fromdate, $todate);
$sql_in->execute();
$res_in = $sql_in->get_result();
while ($row = $res_in->fetch_assoc()) {
    $transactions[] = $row;
}

// OUT (Invoices)
$sql_out = $conn->prepare("
    SELECT i.date as date, id.qty as qty, 'OUT' as type,
           CONCAT('Invoice #', i.idtbl_invoice) as reference,
           c.name as customer
    FROM tbl_invoice_detail id
    INNER JOIN tbl_invoice i ON id.tbl_invoice_idtbl_invoice = i.idtbl_invoice
    LEFT JOIN tbl_customer c ON i.tbl_customer_idtbl_customer = c.idtbl_customer
    WHERE id.tbl_product_idtbl_product=? AND i.date BETWEEN ? AND ?
");
$sql_out->bind_param("iss", $item, $fromdate, $todate);
$sql_out->execute();
$res_out = $sql_out->get_result();
while ($row = $res_out->fetch_assoc()) {
    $transactions[] = $row;
}

// Sort by date
usort($transactions, function ($a, $b) {
    return strtotime($a['date']) - strtotime($b['date']);
});

// -------------------------------
// 6. Build HTML
// -------------------------------
$html = '
<p style="font-weight:bold;font-size:20px;">EVEREST HARDWARE CO. (PVT) LTD;</p>
<p style="font-weight:bold;">#363/10/01, Malwatte, Kal-Eliya (Mirigama).</p>
<p style="font-weight:bold;">033 4 950 951</p>
<p style="font-weight:bold;">everest.hardware@yahoo.com</p><br>

<h3 style="text-align:center;">BIN Report - ' . $product_name . '</h3>
<p style="text-align:center;">From: ' . $fromdate . ' To: ' . $todate . '</p>

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

// Opening balance
$html .= '<tr style="background:#f0f0f0;font-weight:bold;">
            <td colspan="5">Opening Balance (as of ' . $fromdate . ')</td>
            <td>' . $opening_balance . '</td>
          </tr>';

$balance = $opening_balance;

// Transactions
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
    $html .= "<tr>
                <td>{$tr['date']}</td>
                <td>{$tr['reference']}</td>
                <td>{$customer}</td>
                <td style='text-align:center;'>{$inQty}</td>
                <td style='text-align:center;'>{$outQty}</td>
                <td style='text-align:center;'>{$balance}</td>
              </tr>";
}

// Closing balance
$html .= '<tr style="background:#ddd;font-weight:bold;">
            <td colspan="5">Closing Balance (up to ' . $todate . ')</td>
            <td>' . $balance . '</td>
          </tr>';

$html .= '</tbody></table>';

// -------------------------------
// 7. Generate PDF
// -------------------------------
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("BIN_Report_{$product_name}.pdf", ["Attachment" => 0]);
