<?php 
include("config.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();


$isAdmin = isset($_SESSION['is_admin']);
$categoriesResult = $conn->query("SELECT * FROM categories");

$categories = [];
while ($row = $categoriesResult->fetch_assoc()) {
    $categories[] = $row;
}

// Fetch products based on the selected category filter
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : null;
$stockFilter = isset($_GET['stock']) && $_GET['stock'] == 'low';

if ($stockFilter) {
    $sql = "SELECT * FROM products WHERE stock_quantity <= min_quantity";
    $result = $conn->query($sql);

} else {
    // If the button is not pressed, show products based on the selected category filter or all products
    if ($categoryFilter) {
        $categoryFilterString = implode("','", $categoryFilter);
        $sql = "SELECT * FROM products WHERE category_name IN ('$categoryFilterString')";
        $result = $conn->query($sql);
    } else {
        // If no category filter is applied and "Show Low on Stock Products" is not pressed, show all products
        $result = $conn->query("SELECT * FROM products");
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
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
                <a href="category.php" class="nav-link">Categories</a>
            </li>
        </ul>
        <img width="48" src="img/user-286-128.png" alt="profile" class="user-pic">
        <div class="menuwrp" id="subMenu" style="z-index: 99 ;">
            <div class="submenu">
                <div class="userinfo">
                    <?php
            
            // Check if an admin is logged in
            if (isset($_SESSION["admin_username"])) {
              $displayName = $_SESSION["admin_username"];
            } elseif (isset($_SESSION["username"])) {
              $displayName = $_SESSION["username"];
            } else {
              // Redirect to the login page if neither admin nor user is logged in
              header("Location: login.php");
              exit();
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
</nav>

<div class="container mt-4">
    <form action="" method="get" class=" mt-4 justify-content-center">
        <?php
        foreach ($categories as $category) {
            if ($category['bl'] == 1) {
            ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="category[]" value="<?php echo $category['catname']; ?>" 
                <?php if (is_array($categoryFilter) && in_array($category['catname'], $categoryFilter)) echo 'checked'; ?>>
                <label class="form-check-label">
                    <img src="<?php echo $category['imgs']; ?>" alt="<?php echo $category['catname']; ?>" width="50" height="50"><br>
                    <?php echo $category['catname']; ?>
                </label>
            </div>
            <?php
        }
    }
        ?>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="stock" value="low" <?php if ($stockFilter) echo 'checked'; ?>>
            <label class="form-check-label">Low Stock</label>
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
        <?php
                    if ($isAdmin) {
                        echo '<a class="btn btn-primary" href=add.php>ADD</a>';
                        echo '<a class="btn btn-primary ml-1" href=managecat.php>Manage</a>';
    }
    ?>

    </form>

    <div class="row">
        <?php
        // Display products based on the filter
        while ($item = $result->fetch_assoc()) {
            if ($item['bl']) {
                ?>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="<?php echo $item['imgs']; ?>" class="card-img-top" alt="<?php echo $item['productname']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $item['productname']; ?></h5>
                        <h6><?php echo $item['descrip']; ?></h6>
                        <p class="card-text">
                            Final Price: <?php echo $item['final_price']; ?><br>
                            offer Price: <?php echo $item['price_offer']; ?><br>
                            Stock Quantity: <?php echo $item['stock_quantity']; ?><br>
                            Category: <?php echo $item['category_name']; ?>
                        </p>
                        <?php
                    if ($isAdmin) {
                        echo '<a href="edit.php?product_id=' . $item['reference'] . '" class="btn btn-primary">Edit</a>';
                    }
                    ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }

        ?>
        
    </div>

    <script src="index.js"></script>
</body>
</html>