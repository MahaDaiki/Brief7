<?php
session_start();

require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST["fullname"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $phonenumber = $_POST["phonenumber"];
    $adresse = $_POST["adresse"];
    $city = $_POST["city"];

    function isValidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    function isValidPhoneNumber($phoneNumber) {
        $pattern = "/^[0-9]{10}$/"; 
        return preg_match($pattern, $phoneNumber) === 1;
    }

    // Validation errors array
    $errors = [];

    // Validation
    if (empty($fullname)) {
        $errors['fullname'] = "Error: Full Name is required.";
    }
     
    if ($password !== $confirm_password) {
        $errors['password'] = "Error: Passwords do not match.";
    }

    if (!isValidEmail($email)) {
        $errors['email'] = "Error: Invalid email address.";
    }

    if (!isValidPhoneNumber($phonenumber)) {
        $errors['phonenumber'] = "Error: Invalid phone number.";
    }

    // If there are errors, store them in the session variable
    if (!empty($errors)) {
        $_SESSION['register_errors'] = $errors;
        header("Location: signup.php");
        exit();
    }

    // Establish a database connection (replace these with your actual database details)
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL Injection Protection
    $fullname = mysqli_real_escape_string($conn, $fullname);
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
    $phonenumber = (int)$phonenumber; 
    $adresse = mysqli_real_escape_string($conn, $adresse);
    $city = mysqli_real_escape_string($conn, $city);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert user data into the clients table
    $sql = "INSERT INTO clients (fullname, username, email, phonenumber, adresse, city, passw) VALUES ('$fullname', '$username', '$email', $phonenumber, '$adresse', '$city', '$hashed_password')";

    if ($conn->query($sql) === true) {
        echo '<div style="color: green; font-weight: bold; text-align: center;">User registered successfully.</div>';
        header("Location: login.php");
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
