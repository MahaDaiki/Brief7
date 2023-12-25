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



      session_start();
      //Get Products data
      $productsList = $conn->query("SELECT * FROM products WHERE reference in (SELECT product_id from BasketProducts);");


      // Get BasketProducts data and convert it to php array
      if(!isset($_SESSION['basketproducts'])) {
        $basketProductsList = $conn->query("SELECT * FROM BasketProducts")->fetch_all(MYSQLI_ASSOC);
      } else {
        $_SESSION['basketproducts'] = $basketProductsList;
      }
      

      // Convert the result to a PHP array
      $basketArray = [];
      foreach ($basketProductsList as $product) {
          $basketArray[$product['product_id']] = [
              'product_id' => $product['product_id'],
              'quantity' => $product['quantity']
          ];
      }


      // // Quantity change +1
      // function incrementQuantity($productId) {
      //   $basketArray[$productId]['quantity'] +=  1;
      //   showProducts($productsList, $basketArray);
      // }


      // // Quantity change -1
      // function decrementQuantity($productId) {
      //   $basketArray[$productId]['quantity'] -= 1;
      //   showProducts($productsList, $basketArray);
      // }



      
      showProducts($productsList, $basketArray);





    function showProducts($productsList, $basketArray) {
      echo "<section id ='basket-items-container' class='basket-items-container'>";
      
      while($product = $productsList->fetch_assoc()) {
        $productId = $product["reference"];

          echo "<div class='basket-item-container'>";
          echo "<img src='" . $product['imgs'] . "'>";
          echo "<div>";
          echo "<p>" . $product['productname'] . "</p>";
          echo "<p>" . $product['descrip'] . "</p>";
          echo "<p>" . number_format($product['final_price'], 2) . " DH</p>";
          echo "<div>";
          echo "<button class='items-number'>" . $basketArray[$product["reference"]]['quantity'] . "</button>";
          echo '<a href="basket.php?add_item=' . $product["reference"] . '" class="button_a">+</a>';
          echo '<a href="basket.php?remove_item=' . $product["reference"] . '" class="button_a">-</a>';
          echo "</div>";
          echo "</div>";
          echo "</div>";
        
      }
        
        
    
        echo "</section>";
    }
  


    
    if($_SERVER["REQUEST_METHOD"] == "GET") {

      if(isset($_GET["add_item"])) {
        $basketProductsList = $_SESSION['basketproducts'];

        $productId = $_GET["add_item"];
        $basketArray[$productId]['quantity'] += 1;
        $_SESSION['basketproducts'] = $basketProductsList;
        showProducts($productsList, $basketArray);
      }
      if(isset($_GET["remove_item"])) {
        $basketProductsList = $_SESSION['basketproducts'];
        
        $productId = $_GET["remove_item"];
        $basketArray[$productId]['quantity'] -=  1;
        echo "<script>alert('".$basketArray[$productId]['quantity']."')</script>";

        $_SESSION['basketproducts'] = $basketProductsList;
        showProducts($productsList, $basketArray);
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