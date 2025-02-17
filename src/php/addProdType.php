<?php
// Database connection
$serverName = "localhost";
$userNameDB = "root";
$passWordDB = "";
$dbname = "dbspot777coffee";

$conn = new mysqli($serverName, $userNameDB, $passWordDB, $dbname);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Fetch product data

$prodType = filter_input(INPUT_POST, var_name: "productType");
$sqlProdAdd = mysqli_query($conn, "INSERT INTO product_type (product_type) VALUES ('$prodType')"); 

if (!$sqlProdAdd) {
  die("Query failed: " . mysqli_error($conn));
}else{
    echo "Successfully added!!!";
}

?>