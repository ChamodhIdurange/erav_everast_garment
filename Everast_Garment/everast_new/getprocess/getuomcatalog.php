<?php
// Include the database connection file
require_once('../connection/db.php');


    $recordID = $_POST['recordID'];

    
    $sql = "SELECT `uom` FROM `tbl_product` WHERE `status`='1' AND `idtbl_product` = '$recordID'";
    $result = $conn->query($sql);
    if ($result) {
       
        if ($row = mysqli_fetch_array($result)) {
            
            $uom = $row['uom'];
            
            if($uom == 1){
                $uomname = "PCS";
                echo json_encode(array('id' => $uom, 'uom' => $uomname));
            }elseif($uom == 2){
                $uomname = "Packet";
                echo json_encode(array('id' => $uom, 'uom' => $uomname));
            }elseif($uom == 3){
                $uomname = "Box";
                echo json_encode(array('id' => $uom, 'uom' => $uomname));
            }elseif($uom == 4){
                $uomname = "Dozen";
                echo json_encode(array('id' => $uom, 'uom' => $uomname));
            }elseif($uom == 5){
                $uomname = "Kilogram";
                echo json_encode(array('id' => $uom, 'uom' => $uomname));
            }elseif($uom == 6){
                $uomname = "Bottle";
                echo json_encode(array('id' => $uom, 'uom' => $uomname));
            }elseif($uom == 7){
                $uomname = "Roll";
                echo json_encode(array('id' => $uom, 'uom' => $uomname));
            }elseif($uom == 8){
                $uomname = "Tin";
                echo json_encode(array('id' => $uom, 'uom' => $uomname));
            }
            elseif($uom == 79){
                $uomname = "Berall";
                echo json_encode(array('id' => $uom, 'uom' => $uomname));
            }
               
        } 
    } 

?>
