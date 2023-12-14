<?php

session_start(); 
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $username = mysqli_real_escape_string($conn, $username);


    $adminResult = $conn->query("SELECT * FROM admins WHERE username = '$username'");

    if ($adminResult->num_rows > 0) {
        $adminRow = $adminResult->fetch_assoc();
        $adminStoredPassword = $adminRow["passw"];
    
        
        if ($password === $adminStoredPassword) {
            $_SESSION["admin_username"] = $username;
            $_SESSION["is_admin"] = true;

            header("Location: index.php");
            exit();
        } else {
            echo "Error: Incorrect admin password.";
        }
    } else {
        // Check if it's a regular user
        $userResult = $conn->query("SELECT * FROM clients WHERE username = '$username'");

        if ($userResult->num_rows > 0) {
            $userRow = $userResult->fetch_assoc();
            $hashedPassword = $userRow["passw"];
            if (password_verify($password, $hashedPassword)) {
                $_SESSION["username"] = $username;
                header("Location: index.php");
                exit();
            } else {
                echo "Error: Incorrect password.";
            }
        } else {
            echo "Error: User not found.";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body style="background: linear-gradient(to right, #3498db, #5dade2, #85c1e9);">
<div class="overlay"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <form class="login-form" action="login.php" method="post">
                    <h2 class="text-center mb-4">Login</h2>
                    <input class="form-control mb-2" type="text" id="username" name="username" placeholder="Username" required>
                    <input class="form-control mb-2" type="password" id="password" name="password" placeholder="Password" required>
                    <button class="tso btn btn-primary  mt-4" type="submit">Login</button>
                    <hr>
                    <div class="signup-link text-center">
                        <p>Don't have an account? </p>
                        <a href="signup.php">Sign up</a>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
