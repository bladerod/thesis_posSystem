<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Spot777Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css">
  </head>
  <style>
    .qwert{
      padding: 10px;
      width: 100%;
      border: 1px solid rgba(187, 187, 187, 0.5);
      border-radius: 5px;
    }
    .ikaw{
      box-shadow: 2px 2px 17px 1px rgba(0,0,0,0.5);
      background-color: #fff;
      border: none;
      width: 370px;
      height: 100%;
      margin: 200px auto 0 auto;
    }
    .btnSub{
      margin-top: 20px;
      margin-bottom: 0;
      width: 70%;
      margin-left: auto;
      margin-right: auto;
      background-color: #69bff8;
    }
  </style>

  <body>
    <div class="form-control ikaw">
      <h1 class="text-center mt-4 mb-5">Spot777 Coffee</h1>
      <form method="post" action="login.php">
        <input class="qwert mb-2 form-control" type="text" name="userName" id="username" placeholder="Username" required>
        <input class="form-control mb-3" type="password" name="passWord" id="password" placeholder="Password" required>
        <div class="d-flex justify-content-between">
          <div>
            <input type="checkbox" name="rememberMe" id="rememberMe">
            <label for="rememberMe">Remember me</label>
          </div>
          <a href="forgot-password.html">Forgot Password</a>
        </div>
        <button class="form-control btnSub" type="submit">Submit</button><br/>
      </form>   
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.easing.min.js"></script>
  </body>
</html>





<?php
// Start session to manage user login
session_start();

// Get form data
$username = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'passWord', FILTER_SANITIZE_STRING);

// Database connection details
$serverName = "localhost";
$userNameDB = "root";
$passWordDB = "";
$dbname = "dbspot777coffee";

$conn = new mysqli($serverName, $userNameDB, $passWordDB, $dbname);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username and password are not empty
    if (!empty($username) && !empty($password)) {
        // Prepared statement to check the username
        $stmt = $conn->prepare("SELECT * FROM employeetb WHERE user_name = ?");
        $stmt->bind_param("s", $username);  // "s" means a string
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Check if the user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Verify the password
            if (password_verify($password, $user['passWord'])) {
                // Successful login, store session
                $_SESSION['username'] = $username;  // Store username in session
                $_SESSION['user_id'] = $user['id'];  // Store user id in session for reference

                // Redirect to the dashboard or main page
                header("Location: dashboard.php");
                exit();
            } else {
                // Invalid password
                echo "Invalid username or password.";
            }
        } else {
            // Invalid username
            echo "Invalid username or password.";
        }

        $stmt->close();
    } else {
        echo "Both username and password must be provided.";
    }
}

// Close the database connection
$conn->close();
?>
