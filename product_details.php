<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
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
                        <div>
                            <a href="logout.php">Log Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
    <div class="product-container">
        <?php
        include("config.php");

        // Check if the 'reference' parameter is present in the URL
        if (isset($_GET['reference'])) {
            $reference = mysqli_real_escape_string($conn, $_GET['reference']);

            // Fetch product details from the database based on the reference
            $query = "SELECT * FROM Products WHERE reference = '$reference' AND bl = 1";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $product = mysqli_fetch_assoc($result);

                // Display product details
                echo '
                    <div class="row">
                        <div class="col-md-6">
                            <img src="' . $product['imgs'] . '" alt="' . $product['productname'] . '" class="product-image">
                        </div>
                        <div class="col-md-6">
                            <h1>' . $product['productname'] . '</h1>
                            <p><strong>Price:</strong> DH' . $product['final_price'] . '</p>
                            <p><strong>Discount:</strong> DH' . $product['price_offer'] . '</p>
                            <p><strong>Description:</strong> ' . $product['descrip'] . '</p>
                            <p><strong>Category:</strong> ' . $product['category_name'] . '</p>
                            <!-- Add more details as needed -->
                        </div>
                    </div>
                    
                    <a href="index.php" class="btn btn-primary mt-3">Back to Products</a>
                ';
            } else {
                echo '<div class="alert alert-danger" role="alert">Product not found.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Invalid request. Please provide a product reference.</div>';
        }
        ?>
    </div>

    <script src="index.js"></script>
</body>

</html>
