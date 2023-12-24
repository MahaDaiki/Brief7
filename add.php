<?php
session_start(); // Start the session

require_once("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addItem'])) {
    $items = $_POST['items'];

    foreach ($items as $item) {
        // Check if the 'imgs' key exists
        $imgs = isset($item['imgs']) ? $item['imgs'] : null;

        // Initialize $imageFilePath
        $imageFilePath = "";
        if ($imgs !== null) {
            $imagePath = "img/";
            $imageFileName = $imgs['name'];
            $imageFilePath = $imagePath . $imageFileName;

            move_uploaded_file($imgs['tmp_name'], $imageFilePath);
        }

        // Check if 'price_offer' key exists
        $price_offer = isset($item['price_offer']) ? $item['price_offer'] : null;

        // Continue with other key assignments
        $productname = $item['productname'];
        $barcode = $item['barcode'];
        $purchase_price = $item['purchase_price'];
        $final_price = $item['final_price'];
        $descrip = $item['descrip'];
        $min_quantity = $item['min_quantity'];
        $stock_quantity = $item['stock_quantity'];
        $category_name = $item['category_name'];

        // Use $imageFilePath and $price_offer in the SQL query
        $sql = "INSERT INTO Products (imgs, productname, barcode, purchase_price, final_price, price_offer, descrip, min_quantity, stock_quantity, category_name, bl) 
                VALUES ('$imageFilePath', '$productname', '$barcode', '$purchase_price', '$final_price', '$price_offer', '$descrip', '$min_quantity', '$stock_quantity', '$category_name', 1)";
        
        try {
            $conn->query($sql);
        } catch (mysqli_sql_exception $e) {
            echo "Error: " . $sql . "<br>" . $e->getMessage();
        }
    }

    echo "New items added successfully";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body style="background: linear-gradient(to bottom, #6ab1e7,#023364)">

<nav class="navbar navbar-expand-sm navbar-dark ">
    <div class="container">
        <a href="#" class="navbar-brand">NE</a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="home.php" class="nav-link">Home</a>
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
                    // Check if an admin is logged in
                    if (isset($_SESSION["admin_username"])) {
                        $displayName = $_SESSION["admin_username"];
                        $isAdmin = true;
                    } elseif (isset($_SESSION["username"])) {
                        $displayName = $_SESSION["username"];
                        $isAdmin = false;
                    }
                    ?>
                    <div class="userinfo">
                        <img src="img/user-286-128.png" alt="user">
                        <h2>
                            <?php echo $displayName; ?>
                        </h2>
                        <hr>
                        <?php
                        if ($isAdmin) {
                            echo '<a href="adminpan.php">Admin Panel</a>';
                        }
                        ?>
                        <div>
                            <a href="logout.php">Log Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="container formedit   bg-light col-8 mt-5 rounded py-2">
    <h2 class="text-center mb-4">Add Items</h2>
    <form method="post" action="" enctype="multipart/form-data" class="my-5">
        <div class="items-container">
            <div class="item">
                <div class="form-group">
                    <label for="imgs">Image Upload:</label>
                    <input type="file" class="form-control-file" name="items[0][imgs]">
                </div>
                <div class="form-group">
                    <label for="productname">Product Name:</label>
                    <input type="text" class="form-control" name="items[0][productname]" required>
                </div>
                <div class="form-group">
                    <label for="barcode">Barcode:</label>
                    <input type="number" class="form-control" name="items[0][barcode]" required>
                </div>
                <div class="form-group">
                    <label for="purchase_price">Purchase Price:</label>
                    <input type="number" class="form-control" name="items[0][purchase_price]" required>
                </div>
                <div class="form-group">
                    <label for="final_price">Final Price:</label>
                    <input type="number" class="form-control" name="items[0][final_price]" required>
                </div>
                <div class="form-group">
                    <label for="price_offer">Price Offer:</label>
                    <input type="number" class="form-control" name="items[0][price_offer]">
                </div>
                <div class="form-group">
                    <label for="descrip">Description:</label>
                    <textarea class="form-control" name="items[0][descrip]" required></textarea>
                </div>
                <div class="form-group">
                    <label for="min_quantity">Min Quantity:</label>
                    <input type="number" class="form-control" name="items[0][min_quantity]" required>
                </div>
                <div class="form-group">
                    <label for="stock_quantity">Stock Quantity:</label>
                    <input type="number" class="form-control" name="items[0][stock_quantity]" required>
                </div>
                <div class="form-group">
                    <label for="category_name">Category Name:</label>
                    <input type="text" class="form-control" name="items[0][category_name]" required>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-3 ">
            <button type="button" class="btn btn-primary" id="add-item-btn">Add Another Item</button>
            <button type="submit" class="btn btn-danger mx-5" name="addItem">Add Items</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var addItemButton = document.getElementById("add-item-btn");
        var itemsContainer = document.querySelector(".items-container");

        addItemButton.addEventListener("click", function () {
            var firstItem = itemsContainer.querySelector(".item");
            var newItem = firstItem.cloneNode(true);
            itemsContainer.appendChild(newItem);

            // Clear values in the cloned item
            newItem.querySelectorAll("input, textarea").forEach(function (element) {
                element.value = "";
            });
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script src="index.js"></script>
</body>
</html>
