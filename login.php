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
                // $_SESSION["is_client"]= true ;
                $_SESSION["ID_client"]= $userRow["id"];
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
<nav class="navbar navbar-expand-sm navbar-dark ">
    <div class="container">
        <a href="#" class="navbar-brand">NE</a>
        
        <!-- Add the burger menu button for smaller screens -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="items.php" class="nav-link">items</a>
                </li>
            </ul>

            <img width="48" src="img/user-286-128.png" alt="profile" class="user-pic">

            <div class="menuwrp" id="subMenu">
                <div class="submenu">
                    <div class="userinfo">
                    <?php
            
            $displayName = '';
            $isAdmin = false;
           
            if (isset($_SESSION["admin_username"])) {
              $displayName = $_SESSION["admin_username"];
              $isAdmin = true;
            } elseif (isset($_SESSION["username"])) {
              $displayName = $_SESSION["username"];
              $isAdmin = false;
            } if (empty($displayName)) {
                echo '<a href="login.php">Login</a>';
            } else {
                ?>
                <div class="userinfo">
                    <img src="img/user-286-128.png" alt="user">
                    <h2>
                        <?php echo $displayName; ?>
                    </h2>
                    <hr>
                    <?php
                    if ($isAdmin) {
                        echo '<a href="adminpan.php">Admin Panel </a><br>';
                    }
                    echo '<a href="logout.php">Logout</a>'; 
                    ?>
                    <div>
    <?php
}
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<div class="overlay"></div>
    <div class="container">
        <div class="row justify-content-center mt-4">
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
