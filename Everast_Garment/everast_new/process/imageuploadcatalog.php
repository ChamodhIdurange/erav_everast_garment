<?php
require_once('../connection/db.php');
// Assuming you have the file path and database connection already set
$id = $_POST['id']; // The ID of the file you want to delete
$errors = [];

// Fetch the file path from the database
$query = "SELECT imagepath FROM tbl_product_image WHERE idtbl_product_image = $id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $filePath = "../" . $row['imagepath']; // Add "../" to match the full path

    $deleteQuery = "DELETE FROM tbl_product_image WHERE idtbl_product_image = $id";
    if ($conn->query($deleteQuery) === TRUE) {
        echo "File deleted successfully";
    } else {
        $errors[] = "Error deleting record from database: " . $conn->error;
    }
} else {
    $errors[] = "File not found in database.";
}

// Display any errors
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
}
?>
