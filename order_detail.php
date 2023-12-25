<?php
require_once("config.php");
session_start();

if (isset($_SESSION["admin_username"])) {
    $isAdmin = true;
} else {
    header("Location: index.php");
    exit();
}

// manage order's status
if (isset($_GET["verify_order"])) {
    $ord_id = $_GET["verify_order"];

    $stmt = $conn->prepare("UPDATE orders SET bl = 1 WHERE id = $ord_id");
    $stmt->execute();
    

    header("Location: order_detail.php?reference={$ord_id}");
    exit();
}

if (isset($_GET["unverify_order"])) {
    $ord_id = $_GET["unverify_order"];

    $stmt = $conn->prepare("UPDATE orders SET bl = 0 WHERE id = $ord_id");
    $stmt->execute();

    header("Location: order_detail.php?reference={$ord_id}");
    exit();
}

if (isset($_GET["delete_order"])) {
    $ord_id = $_GET["delete_order"];

    $stmt = $conn->prepare("DELETE FROM orders WHERE id = $ord_id");
    $stmt->execute();

    header("Location: adminpan.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            
        }

        .product-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
    </style>
</head>

<body>
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
                        if (isset($_SESSION["admin_username"])) {
                        $displayName = $_SESSION["admin_username"];
                        $isAdmin = true;
                        } elseif (isset($_SESSION["username"])) {
                        $displayName = $_SESSION["username"];
                        $isAdmin = false;
                        } else {
                        // Redirect to the login page if neither admin nor user is logged in
                        header("Location: index.php");
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
            </div>
        </div>
    </div>
</nav>
        <?php

        // Check if the 'reference' parameter is present in the URL
        if (isset($_GET['reference'])) {
            $order_id = $_GET['reference'];
            // Fetch product details from the database based on the reference
            $order_result = $conn->query("SELECT orders.id, clients.fullname, orders.creation_date, orders.shipping_date, orders.delivery_date, orders.total_price, orders.bl
                                FROM orders  INNER JOIN clients 
                                ON orders.client_id=clients.id WHERE orders.id=$order_id");
            $order_prod_result = $conn->query("SELECT products.reference, products.productname, products.purchase_price, orderproduct.quantity 
                                                FROM products INNER JOIN orderproduct
                                                ON orderproduct.product_ref = products.reference WHERE orderproduct.order_id=$order_id");

            if (!empty($order_result)) {
                $ord=$order_result->fetch_assoc();

                // Display order details 
                echo '<div class="row">';
                echo '<div class="container mt-5">';
                echo '<h3 class="mt-5 text-center">Orders detail</h3>';
                echo '<table class="table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>order id</th>';
                echo '<th>client name</th>';
                echo '<th>creation date</th>';
                echo '<th>sending date</th>';
                echo '<th>delivring date</th>';
                echo '</tr>';
                echo '</thead>';
                // $ord = $order_detail-> fetch_assoc();
                echo '<tbody>';
                echo '<tr>';
                echo "<td>{$ord['id']}</td>";
                echo "<td>{$ord['fullname']}</td>";
                echo "<td>{$ord['creation_date']}</td>";
                echo "<td>{$ord['shipping_date']}</td>";
                echo "<td>{$ord['delivery_date']}</td>";
                echo '</tr>';
                echo '</tbody>';
                echo '</table>';
            
                echo '<h4>Ordered products</h4>';
                echo '<table class="table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Reference</th>';
                echo '<th>Product</th>';
                echo '<th>Quantity</th>';
                echo '<th>Total price</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while($ord_prod = $order_prod_result->fetch_assoc()){
                    echo '<tr>';
                    echo "<td>{$ord_prod['reference']}</td>";
                    echo "<td>{$ord_prod['productname']}</td>";
                    echo "<td>{$ord_prod['quantity']}</td>";
                    $prod_price = $ord_prod['purchase_price']*$ord_prod['quantity'];
                    echo "<td>{$prod_price}</td>";
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
                echo "<h5>Order's total Price:{$ord['total_price']}</h5>";
                echo '<div class="d-flex align-items-center column-gap-5">';
                echo "<h5>Order's status</h5>";
                if (isset($ord['bl']) && $ord['bl'] == 0) {
                    echo "<p>Unvalid order</p>";
                    echo "<a href='order_detail.php?verify_order={$ord['id']}' class='btn btn-success btn-sm mr-2'>Valid</a>";
                }else {
                    echo "<p>Valid order</p>";
                    echo "<a href='order_detail.php?unverify_order={$ord['id']}' class='btn btn-warning btn-sm mr-2'>Unvalid</a>";
                }
                echo '</div>';
                echo "<a href='order_detail.php?delete_order={$ord['id']}' class='btn btn-danger btn-sm mr-2'>Delete order</a>";
                echo '</div>';
                echo '</div>';
                
                echo '<a href="adminpan.php" class="btn btn-primary mt-3">Back to Panel</a>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Order not found.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Invalid request. Please provide an order reference.</div>';
        }
        ?>
    <script src="index.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="assets/js/home.js"></script>

</body>

</html>
