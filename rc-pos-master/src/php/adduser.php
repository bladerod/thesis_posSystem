<?php

// Collecting form input data
$firstname = filter_input(INPUT_POST, 'fname');
$lastname = filter_input(INPUT_POST, 'lname');
$birthdate = filter_input(INPUT_POST, 'birthdate');
$gender = filter_input(INPUT_POST, 'gender');
$username = filter_input(INPUT_POST, 'user_name');
$password = filter_input(INPUT_POST, 'pass_word');

// Database connection details
$serverName = "localhost";
$userNameDB = "root";
$passWordDB = "";
$dbname = "dbspot777coffee";

// Create connection
$conn = new mysqli($serverName, $userNameDB, $passWordDB, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Hash the password before inserting into the database
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Prepare the SQL query with placeholders
$sql = "INSERT INTO employeetb (fname, lname, birthdate, gender, user_name, pass_word) 
        VALUES (?, ?, ?, ?, ?, ?)";

// Prepare statement
$stmt = $conn->prepare($sql);

// Bind the input parameters to the prepared statement
$stmt->bind_param("ssssss", $firstname, $lastname, $birthdate, $gender, $username, $hashedPassword);

// Execute the prepared statement
if ($stmt->execute()) {
    echo "New record inserted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();

?>
