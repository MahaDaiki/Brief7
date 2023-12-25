<?php
require_once("config.php");

// Assuming $clientId is obtained from your application
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(['success' => false, 'error' => 'Invalid JSON data']);
    exit();
}

try {
    // Calculate the total price based on the items in the cart
    $totalPrice = 0;

    foreach ($data as $item) {
        $quantity = $item['quantity'];
        $productRef = $item['reference'];

        // Fetch the product price from the database based on $productRef
        $productPriceQuery = "SELECT final_price FROM products WHERE reference = ?";
        $productPriceStmt = $pdo->prepare($productPriceQuery);

        if ($productPriceStmt->execute([$productRef])) {
            $productPrice = $productPriceStmt->fetch(PDO::FETCH_ASSOC);

            if ($productPrice) {
                $totalPrice += $productPrice['final_price'] * $quantity;
            } else {
                // Handle error: Unable to fetch product price
                echo json_encode(['success' => false, 'error' => 'Invalid product reference']);
                exit();
            }
        } else {
            // Handle error: Unable to execute query
            echo json_encode(['success' => false, 'error' => 'Unable to fetch product price']);
            exit();
        }
    }

    // Insert into the orders table
    $orderInsertQuery = "INSERT INTO orders (creation_date, total_price, client_id) VALUES (NOW(), ?, ?)";
    $orderInsertStmt = $pdo->prepare($orderInsertQuery);

    if ($orderInsertStmt->execute([$totalPrice, $clientId])) {
        // Get the last inserted order_id
        $orderId = $pdo->lastInsertId();

        // Process the data and insert it into the orderproduct table
        foreach ($data as $item) {
            $productRef = $item['reference'];
            $quantity = $item['quantity'];

            // Insert into the orderproduct table
            $orderProductInsertQuery = "INSERT INTO orderproduct (order_id, product_ref, quantity) VALUES (?, ?, ?)";
            $orderProductInsertStmt = $pdo->prepare($orderProductInsertQuery);

            if (!$orderProductInsertStmt->execute([$orderId, $productRef, $quantity])) {
                // Handle error: Unable to insert into orderproduct table
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
