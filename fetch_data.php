<?php
include("config.php");

// Set default values for pagination
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$records_per_page = 10;
$offset = ($page - 1) * $records_per_page;

if (isset($_POST["action"]) && $_POST["action"] == 'fetch_data') {
    $query = "SELECT * FROM Products WHERE bl = 1";

    // Check if category is set and not empty
    if (isset($_POST["category"]) && !empty($_POST["category"])) {
        // Decode the JSON string to an array
        $category_array = json_decode($_POST["category"], true);

        // Check if $category_array is an array before using implode
        if (is_array($category_array)) {
            $category_filter = implode("','", $category_array);
            $query .= " AND category_name IN ('" . $category_filter . "')";
        } else {
            // Handle the case where $category_array is not an array
            echo 'Invalid category data received.';
            exit;
        }
    }

    // Count total number of rows without limit
    $total_result = mysqli_query($conn, $query);
    $total_records = mysqli_num_rows($total_result);

    // Add pagination to the main query
    $query .= " LIMIT $offset, $records_per_page";

    $result = mysqli_query($conn, $query);
    $total_row = mysqli_num_rows($result);

    if ($total_row > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '
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

        // Display pagination links
        $total_pages = ceil($total_records / $records_per_page);
        echo '<div class="col-12 mt-4">';
        echo '<ul class="pagination justify-content-center">';
        for ($i = 1; $i <= $total_pages; $i++) {
            echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '"><a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a></li>';
        }
        echo '</ul>';
        echo '</div>';
    } 
}
?>
