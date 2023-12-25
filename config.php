<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
<<<<<<< HEAD
define('DB_PASS', '');
=======
define('DB_PASS', 'berg@1234');
>>>>>>> eb8a77e81452b7e17f8499e4079484dec8c65a5e
define('DB_NAME', 'electronacerdb7');

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

