<!DOCTYPE html>

<html>

<head>
    <title>Basket</title>
    <meta name="description" content="An Asian restaurant that offers you a new and distinctive atmosphere.">
    <meta name="keywords" content="asian, food, restaurant">
    <meta charset="UTF-8">

    <link rel="stylesheet" href="assets/css/basket.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

</head>



<body>





    <!-- Your Cart -->
    <p class="large-title" >Your cart:</p>
    <!-- Your Cart -->


    <?php


      include("config.php");


    //   $orderProductList = [
    //     ['order_id' => 1, 'product_ref' => 101, 'quantity' => 2],
    //     ['order_id' => 1, 'product_ref' => 102, 'quantity' => 1],
    //     ['order_id' => 2, 'product_ref' => 101, 'quantity' => 3],
    //     ['order_id' => 2, 'product_ref' => 103, 'quantity' => 2],
    //     ['order_id' => 3, 'product_ref' => 102, 'quantity' => 1],
    // ];

    $productsList = $conn->query("SELECT * FROM Products where stock_quantity > 15;");

    // while($product = $productsList->fetch_assoc()) {

      echo"<div class = 'basket-item-container'>";
      echo "<img src='img/ram3.jpg'>";
      echo "<div>";
      echo "<p>RAM</p>";
      echo "<p>DESCRIPTION</p>";
      echo "<p>250 DH</p>";
      echo "<div>";
      echo "<button class='items-number'>15</button>";
      echo "<button class='add-item'>+</button>";
      echo "<button class='remove-item'>-</button>";
      echo "</div>";
      echo "</div>";

    // }


    ?>

    <!-- Basket Items -->
    <section id ="basket-items-container" class="basket-items-container">
      
      <!-- The data will be show after getting it from local storage -->

    </section>
    <!-- Basket Items -->


    
    <!-- <section class="after-shopping-section">
      <button id="confirm-order">Confirm Order & Empty Cart</button>
      <button id="request-quote">Request a Quote</button>
    </section> -->





    <script src="assets/js/basket.js"></script>
</body>






</html>