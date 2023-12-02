<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body style="background: linear-gradient(to right, #3498db, #5dade2, #85c1e9);" >
    <div class="overlay"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
            <form class="d-flex flex-column p-4 bg-white rounded shadow-sm" action="register.php" method="post">
                    <h2 class="text-center mb-4">Sign Up</h2>
                    <input class="form-control mb-2" type="text" id="fullname" name="fullname" placeholder="Full Name" required>
                    <?php
                        if (isset($_SESSION['register_errors']['fullname'])) {
                            echo '<div style="color: red; font-weight: bold; text-align: left;">' . $_SESSION['register_errors']['fullname'] . '</div>';
                        }
                    ?>
                    
                    <input class="form-control mb-2" type="text" id="username" name="username" placeholder="Username" required>
                    <?php
                        if (isset($_SESSION['register_errors']['username'])) {
                            echo '<div style="color: red; font-weight: bold; text-align: left;">' . $_SESSION['register_errors']['username'] . '</div>';
                        }
                    ?>

                    <input class="form-control mb-2" type="email" id="email" name="email" placeholder="Email" required>
                    <?php
                        if (isset($_SESSION['register_errors']['email'])) {
                            echo '<div style="color: red; font-weight: bold; text-align: left;">' . $_SESSION['register_errors']['email'] . '</div>';
                        }
                    ?>

                    <input class="form-control mb-2" type="text" id="phonenumber" name="phonenumber" placeholder="Phone Number" required>
                    <?php
                        if (isset($_SESSION['register_errors']['phonenumber'])) {
                            echo '<div style="color: red; font-weight: bold; text-align: left;">' . $_SESSION['register_errors']['phonenumber'] . '</div>';
                        }
                    ?>

                    <input class="form-control mb-2" type="text" id="adresse" name="adresse" placeholder="Address" required>
                    <input class="form-control mb-2" type="text" id="city" name="city" placeholder="City" required>
                    <input class="form-control mb-2" type="password" id="password" name="password" placeholder="Password" required>
                    <input class="form-control mb-2" type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                    <button class="tso btn btn-primary mt-4" type="submit">Sign Up</button>
                    <hr>
                    <div class="signup-link text-center">
                        <p>Already have an account? </p>
                        <a href="login.php">Log In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
    unset($_SESSION['register_errors']);
?>
