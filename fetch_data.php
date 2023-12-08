<?php
include("config.php");

function generateProductCard($row) {
    return '
    <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
        <div class="card h-100 border-0 shadow product-card">
        <a href="product_details.php?reference=' . $row['reference'] . '" class="text-decoration-none text-dark">
            <img src="' . $row['imgs'] . '" alt="' . $row['productname'] . '" class="card-img-top">
            <div class="card-body">
                <h5 class="card-title"><a href="#" class="text-decoration-none text-dark">' . $row['productname'] . '</a></h5>
                <h6 class="card-subtitle mb-2 text-danger">Price: DH' . $row['final_price'] . '</h6>
                <h6 class="card-subtitle mb-2 text-danger">DISCOUNT: DH ' . $row['price_offer'] . '</h6><br>
                <p class="card-text">
                    <strong>Description:</strong> ' . $row['descrip'] . '<br>
                    
                    <strong></strong> '. $row['category_name'] .'  <br>
                   
                </p>
            </div>
            <div class="card-footer bg-white">
                <button class="btn btn-primary btn-sm add-to-cart" data-product-id="' . $row['reference'] . '">Add to Cart</button>
                <button class="btn btn-danger btn-sm admin-only-button" data-product-id="' . $row['reference'] . '">Admin Only</button>
            </div>
        </div>
    </div>';
}


$query = "SELECT * FROM Products WHERE bl = 1";

if (isset($_POST["category"]) && !empty($_POST["category"])) {
    $category_array = json_decode($_POST["category"], true);
    if (is_array($category_array)) {
        $category_filter = implode("','", $category_array);
        $query .= " AND category_name IN ('" . $category_filter . "')";
    }
}

// Check if sorting alphabetically is requested
$sortAlphabetically = isset($_POST['sort_alphabetically']) ? (bool)$_POST['sort_alphabetically'] : false;

if ($sortAlphabetically) {
    $query .= " ORDER BY productname ASC";
}

// Search filter
$searchQuery = mysqli_real_escape_string($conn, $_POST['search_query']);
$searchFilter = mysqli_real_escape_string($conn, $searchQuery);

if ($searchFilter != '') {
    $query .= " AND (productname LIKE '%" . $searchFilter . "%' OR descrip LIKE '%" . $searchFilter . "%')";
}

// Stock filter
$stockFilter = isset($_POST['stock_filter']) ? $_POST['stock_filter'] : false;

if ($stockFilter) {
    $query .= " AND stock_quantity <= min_quantity";
}

$result = mysqli_query($conn, $query);
$total_row = mysqli_num_rows($result);

if ($total_row > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo generateProductCard($row);
    }
} else {
    // Display all items if no specific category is selected
    $all_items_query = "SELECT * FROM Products WHERE bl = 1";

    if ($sortAlphabetically) {
        $all_items_query .= " ORDER BY productname ASC";
    }

    $all_items_result = mysqli_query($conn, $all_items_query);

    while ($row = mysqli_fetch_assoc($all_items_result)) {
        echo generateProductCard($row);
    }
}
?>
    
   


