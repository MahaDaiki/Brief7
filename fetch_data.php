<?php
include("config.php");

function generateProductCard($row) {
    return '
    <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
        <div class="card h-100 border-0 shadow product-card">
            <img src="' . $row['imgs'] . '" alt="' . $row['productname'] . '" class="card-img-top">
            <div class="card-body">
                <h5 class="card-title"><a href="#" class="text-decoration-none text-dark">' . $row['productname'] . '</a></h5>
                <h6 class="card-subtitle mb-2 text-danger">Price: $' . $row['final_price'] . '</h6>
                <p class="card-text">
                    <strong>Description:</strong> ' . $row['descrip'] . '<br>
                    <strong>Min Quantity:</strong> ' . $row['min_quantity'] . '<br>
                    <strong>Stock Quantity:</strong> ' . $row['stock_quantity'] . '
                </p>
            </div>
            <div class="card-footer bg-white">
                <button class="btn btn-primary btn-sm add-to-cart" data-product-id="' . $row['reference'] . '">Add to Cart</button>
                <button class="btn btn-danger btn-sm admin-only-button" data-product-id="' . $row['reference'] . '">Admin Only</button>
            </div>
        </div>
    </div>';
}

if ($_POST['action'] == 'search_data') {
    $searchQuery = mysqli_real_escape_string($conn, $_POST['search_query']);
    $query = "SELECT * FROM Products WHERE bl = 1 AND product_name LIKE '%$searchQuery%'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Results found
        while ($row = mysqli_fetch_assoc($result)) {
            echo generateProductCard($row);
        }
    } else {
        echo 'Nothing found';
    }
}

if (isset($_POST["action"]) && $_POST["action"] == 'fetch_data') {
    $query = "SELECT * FROM Products WHERE bl = 1";

    if (isset($_POST["category"])) {
        // Decode the JSON string to an array
        $category_array = json_decode($_POST["category"], true);

        if (is_array($category_array)) {
            $category_filter = implode("','", $category_array);
            $query .= " AND category_name IN ('" . $category_filter . "')";
        } else {
            echo 'Invalid category data received.';
            exit;
        }
    }

    $result = mysqli_query($conn, $query);
    $total_row = mysqli_num_rows($result);

    if ($total_row > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo generateProductCard($row);
        }
    } else {
        // If no results are found based on the category filter, fetch all items
        $all_items_query = "SELECT * FROM Products WHERE bl = 1";
        $all_items_result = mysqli_query($conn, $all_items_query);

        while ($row = mysqli_fetch_assoc($all_items_result)) {
            echo generateProductCard($row);
        }
    }
}
?>
