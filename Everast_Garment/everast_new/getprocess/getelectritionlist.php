<?php
require_once('../connection/db.php');

session_start();
$points=$_POST['points'];

$array = [];


$sql2="SELECT  `idtbl_electrician`, `name` from `tbl_electrician` WHERE `star_points` >= '$points' and `status` = '1' ";
$result2 =$conn-> query($sql2); 



while ($row = $result2-> fetch_assoc()) { 
    $obj=new stdClass();
    $obj->elecid=$row['idtbl_electrician'];
    $obj->elecname=$row['name'];
    array_push($array,$obj);
}


echo json_encode($array);
?>