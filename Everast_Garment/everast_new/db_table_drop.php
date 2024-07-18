<?php
$host = 'localhost';  
$user = 'root';  
$pass = 'asela123';  
$dbname = 'erav_ansengas';  
$conn = mysqli_connect($host, $user, $pass, $dbname);  

if(!$conn) {  
die('Could not connect: '.mysqli_connect_error());  
}  
echo 'Connected successfully<br/>';  
$sql = "DROP TABLE tbl_porder";

if(mysqli_query($conn, $sql)) {  
echo "Table is deleted successfully";  
} else {  
echo "Table is not deleted successfully\n";
}  
mysqli_close($conn); 
?>
