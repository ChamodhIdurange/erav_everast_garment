<?php
$mysqli = new mysqli('localhost', 'root', 'asela123' , 'erav_ansengas');
$mysqli->query('SET foreign_key_checks = 0');
if ($result = $mysqli->query("SHOW TABLES"))
{
    while($row = $result->fetch_array(MYSQLI_NUM))
    {
    //    echo $row[0].'<br>';
       if($row[0]=='tbl_invoice_payment_has_tbl_invoice'){
            $mysqli->query('TRUNCATE '.$row[0]);
            // echo $row[0].'<br>';
       }
    //     // $mysqli->query('TRUNCATE '.$row[0]);
    }
}

$mysqli->query('SET foreign_key_checks = 1');
$mysqli->close();
?>