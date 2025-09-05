<?php
require_once('../connection/db.php');
header('Content-Type: application/json');

$ym = isset($_POST['ym']) ? $_POST['ym'] : '';
if ($ym === '') {
  echo json_encode(['submitted' => false]);
  exit;
}

$stmt = $conn->prepare("SELECT 1 FROM tbl_month_end WHERE DATE_FORMAT(date,'%Y-%m') = ? LIMIT 1");
$stmt->bind_param("s", $ym);
$stmt->execute();
$stmt->store_result();
$submitted = $stmt->num_rows > 0;
$stmt->close();

echo json_encode(['submitted' => $submitted]);
