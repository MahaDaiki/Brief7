<?php
include ("config.php");

if(isset($_POST["submit_insert"])){
    insertProduct();

}
function insertProduct(){
    global $conn;
    
    $name = $_POST["cat_name"];
    $description  = $_POST["cat_desc"];
    $bl = $_POST["bl"];
    $imgs = "hellofjslfd ldjfl";

    $query = "INSERT INTO categories (catname, descrip, imgs, bl) VALUES (?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $query);
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssss", $name, $description, $bl, $imgs);

    mysqli_stmt_execute($stmt);
    
    mysqli_stmt_close($stmt);
}
