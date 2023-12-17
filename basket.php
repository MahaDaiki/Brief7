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
      $productsList = $conn->query("SELECT * FROM Products WHERE stock_quantity > 15;");
      
      function incrementQuantity($productId) {
        foreach ($productsList as $product) {
          if ($product['reference'] == $productId) {
            $product['stock_quantity'] = $product['stock_quantity'] + 1;
            $productsList[0]['stock_quantity'] = 5;
            break;
          }
        }
      }


      function decrementQuantity($productId) {
        foreach ($productsList as $product) {
          if ($product['reference'] == $productId) {
            $product['stock_quantity'] = $product['stock_quantity'] - 1;
            break;
          }
        }
      }


      
      showProducts($productsList);





    function showProducts($productsList) {
      echo "<section id ='basket-items-container' class='basket-items-container'>";
      
      while($product = $productsList->fetch_assoc()) {
        echo "<script>alert('".$product['stock_quantity']."');</script>";

          echo "<div class='basket-item-container'>";
          echo "<img src='" . $product['imgs'] . "'>";
          echo "<div>";
          echo "<p>" . $product['productname'] . "</p>";
          echo "<p>" . $product['descrip'] . "</p>";
          echo "<p>" . number_format($product['final_price'], 2) . " DH</p>";
          echo "<div>";
          echo "<button class='items-number'>" . $product['stock_quantity'] . "</button>";
          echo '<a href="basket.php?add_item=' . $product["reference"] . '" class="button_a">+</a>';
          echo '<a href="basket.php?remove_item=' . $product["reference"] . '" class="button_a">-</a>';
          echo "</div>";
          echo "</div>";
          echo "</div>";
        
      }
        
        
    
        echo "</section>";
    }
  






    if($_SERVER['REQUEST_METHOD'] == 'GET') {
      if(isset($_GET['add_item'])) {
        $id = $_GET['add_item'];
        incrementQuantity($id);
        showProducts();
      }

      if(isset($_GET['remove_item'])) {
        $id = $_GET['remove_item'];
        desincrementQuantity($id);

      }
    }
    ?>






    
    <!-- <section class="after-shopping-section">
      <button id="confirm-order">Confirm Order & Empty Cart</button>
      <button id="request-quote">Request a Quote</button>
    </section> -->





    <script src="assets/js/basket.js"></script>
</body>






</html>