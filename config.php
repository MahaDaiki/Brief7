<?php

define('DB_HOST', 'localhost');     
define('DB_USER', 'root');     
define('DB_PASS', 'Chems@B2001'); 
define('DB_NAME', 'electronacerb7');     

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
