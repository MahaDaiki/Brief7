<?php
session_start();
include("config.php");
$isAdmin = isset($_SESSION['is_admin']);
function generateProductCard($row,$isAdmin) {
   
    $adminButton = $isAdmin ? '<button class="btn btn-danger btn-sm admin-only-button" data-product-id="' . $row['reference'] . '">Modify</button>' : '';

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
                ' . $adminButton . '
            </div>
        </div>
    </div>';
}

if(isset($_POST['page'])) {
    $page = $_POST['page'];
}
$limit = 8;
$offset = ($page - 1) * $limit;
// Check if sorting alphabetically is requested
$sortAlphabetically = isset($_POST['sort_alphabetically']) ? (bool)$_POST['sort_alphabetically'] : false;

// Search filter
$searchQuery = mysqli_real_escape_string($conn, $_POST['search_query']);
$searchFilter = mysqli_real_escape_string($conn, $searchQuery);

// Stock filter
$stockFilter = isset($_POST['stock_filter']) ? $_POST['stock_filter'] : false;

// Regular query
$query = "SELECT * FROM Products WHERE bl = 1";

if (isset($_POST["category"]) && !empty($_POST["category"])) {
    $category_array = json_decode($_POST["category"], true);
    if (is_array($category_array)) {
        $category_filter = implode("','", $category_array);
        $query .= " AND category_name IN ('" . $category_filter . "')";
    }
}

if ($searchFilter != '') {
    $query .= " AND (productname LIKE '%" . $searchFilter . "%' OR descrip LIKE '%" . $searchFilter . "%')";
}

if ($stockFilter) {
    $query .= " AND stock_quantity < products.min_quantity";
}

if ($sortAlphabetically) {
    $query .= " ORDER BY productname ASC";
}

// Count total rows without LIMIT for pagination
$total_regular_items = mysqli_num_rows(mysqli_query($conn, $query));
$query .= " LIMIT $offset, $limit";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo generateProductCard($row,$isAdmin);
    }

    // Generate pagination links for regular query
    $total_regular_pages = ceil($total_regular_items / $limit);
    echo '<ul class="pagination">';
    for ($i = 1; $i <= $total_regular_pages; $i++) {
        echo '<li class="page-item"><a class="page-link pagination-link" href="#" onclick="filter_data(' . $i . ')" id="' . $i . '">' . $i . '</a></li>';
    }
    echo '</ul>';
} 


// "All items" query
$all_items_query = "SELECT * FROM Products WHERE bl = 1";

if ($searchFilter != '') {
    $all_items_query .= " AND (productname LIKE '%" . $searchFilter . "%' OR descrip LIKE '%" . $searchFilter . "%')";
}

if ($stockFilter) {
    $all_items_query .= " AND (stock_quantity <= Products.min_quantity)";
}

if ($sortAlphabetically) {
    $all_items_query .= " ORDER BY productname ASC";
}

// Count total rows without LIMIT for pagination
$total_all_items = mysqli_num_rows(mysqli_query($conn, $all_items_query));

$all_items_query .= " LIMIT $offset, $limit";
$all_items_result = mysqli_query($conn, $all_items_query);

if (mysqli_num_rows($all_items_result) > 0) {
    while ($row = mysqli_fetch_assoc($all_items_result)) {
        echo generateProductCard($row, $isAdmin);
    }

    // Generate pagination links for "all items" query
    $total_all_pages = ceil($total_all_items / $limit);
    echo '<ul class="pagination">';
    for ($i = 1; $i <= $total_all_pages; $i++) {
        echo '<li class="page-item"><a class="page-link pagination-link" href="#" onclick="filter_data(' . $i . ')" id="' . $i . '">' . $i . '</a></li>';
    }
    echo '</ul>';
} 
?>

