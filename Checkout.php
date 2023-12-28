<?php
require_once("config.php");

session_start();

if (!isset($_SESSION['ID_client'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    // exit();
}

$clientId = $_SESSION['ID_client'];

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(['success' => false, 'error' => 'Invalid JSON data']);
    // exit();
}

try {
    // Calculate the total price based on the items in the cart
    $totalPrice = 0;

    foreach ($data as $item) {
        $quantity = $item['quantity'];
        $productRef = $item['reference'];

        $productPriceQuery = "SELECT final_price FROM products WHERE reference = '$productRef'";
        $productPriceResult = mysqli_query($conn, $productPriceQuery);

        if ($productPriceResult) {
            $productPrice = mysqli_fetch_assoc($productPriceResult);
            $totalPrice += $productPrice['final_price'] * $quantity;
        } else {
            echo json_encode(['success' => false, 'error' => 'Unable to fetch product price']);
            // exit();
        }
    }

    // Insert into the orders table
    $orderInsertQuery = "INSERT INTO orders (creation_date, total_price, client_id) VALUES (NOW(), $totalPrice, $clientId)";
    $orderInsertResult = mysqli_query($conn, $orderInsertQuery);

    if ($orderInsertResult) {
        // Get the last inserted order_id
        $orderId = mysqli_insert_id($conn);
        foreach ($data as $item) {
            $productRef = $item['reference'];
            $quantity = $item['quantity'];

            $orderProductInsertQuery = "INSERT INTO orderproduct (order_id, product_ref, quantity) VALUES ($orderId, '$productRef', $quantity)";
            $orderProductInsertResult = mysqli_query($conn, $orderProductInsertQuery);

            if (!$orderProductInsertResult) {
                echo json_encode(['success' => false, 'error' => 'Unable to insert into orderproduct table']);
                exit();
            }
        }

        echo json_encode(['success' => true, 'order_id' => $orderId]);
    } else {
        // Handle error: Unable to insert into orders table
        echo json_encode(['success' => false, 'error' => 'Unable to insert into orders table']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
