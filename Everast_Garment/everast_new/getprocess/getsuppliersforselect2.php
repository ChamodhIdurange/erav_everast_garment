<?php 
require_once('../connection/db.php');


if(!isset($_POST['searchTerm'])){ 
    $sql="SELECT `idtbl_supplier`, `suppliername` FROM `tbl_supplier` LIMIT 5";

}else{
    $search = $_POST['searchTerm'];   
    $sql="SELECT `idtbl_supplier`, `suppliername` FROM `tbl_supplier` AND `suppliername` LIKE '%$search%'";

}
$result=$conn->query($sql);


$arraylist=array();


while($row=$result->fetch_assoc()){
    $obj=new stdClass();
    $obj->id=$row['idtbl_supplier'];
    $obj->text=$row['suppliername'];
    
    array_push($arraylist, $obj);
}



echo json_encode($arraylist);
?>