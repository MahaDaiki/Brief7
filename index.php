<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Electro nacer website for arduino its tools.">
    <meta name="keywords" content="arduino, electro, buy arduino UNO">
    <meta name="author" content="YOUCODE">
    <title>ELECTRO NACER - HOME</title>
    <link rel="stylesheet" type="text/css" href="assets/css/home.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

    <?php

        $connection = new mysqli("localhost", "root", "", "electronacerdb7");

        if(!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }


        $categoriesList = $connection->query("SELECT * FROM Categories;");
        $productsList = $connection->query("SELECT * FROM Products where stock_quantity > 15;");




    ?>

    <!-- Welcome section -->
    <section class="home-welcome-section">

        <div class="home-welcome-p-container">
            <p class="home-welcome-p">ELECTRO NACER</p>
        </div>


        <div class="home-welcome-img-container">
            <img class="home-welcome-img" src="img/electro-nacer.png">
        </div>

    </section>
    <!-- Welcome section -->




    <!-- POPULAR PRODUCTS  -->
    <h3 style="color: rgb(0, 137, 236); margin: 50px;">
        POPULAR PRODUCTS
        <small class="text-muted">Best-selling products</small>
    </h3>
    
        
        <?php
            echo '<div class="card-deck" style="margin: 50px;">';
            while($product = $productsList->fetch_assoc()) {
                echo '<div class="card" style="background-color: rgb(169, 201, 223); ">';
                echo '<img class="card-img-top" src="'.$product['imgs'].'" alt="Card image cap">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">'.$product['productname'].'</h5>';
                echo '<p class="card-text">'.$product['descrip'].'</p>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        ?>

    
    <!-- POPULAR PRODUCTS  -->



    <!-- CATEGORIES  -->
    <h3 style="color: rgb(0, 137, 236); margin: 50px;">
        CATEGORIES
        <small class="text-muted">Many and many categories and special pieces</small>
    </h3>
    <div class="card-deck" style="margin: 50px;">
        
    <?php
            echo '<div class="card-deck" style="margin: 50px;">';
            while($category = $categoriesList->fetch_assoc()) {
                echo '<div class="card" style="background-color: rgb(169, 201, 223); ">';
                echo '<img class="card-img-top" src="'.$category['imgs'].'" alt="Card image cap">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">'.$category['catname'].'</h5>';
                echo '<p class="card-text">'.$category['descrip'].'</p>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        ?>

    </div>
    <!-- CATEGORIES  -->




    <!-- ABOUT US -->
    <h3 style="color: #0096FF; margin: 50px;">
        EXPLORE OUR SUPERPOWERS
        <small class="text-muted">Unleashing Extraordinary Features</small>
    </h3>
    <div class="row" style="margin: 50px;">

        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Rare pieces</h5>
              <p class="card-text">Explore the extraordinary with our Rare Pieces collection. Discover unique and hard-to-find electronic gems available exclusively at our store. Elevate your tech experience today.</p>
              <a href="#" class="btn btn-primary">Learn more</a>
            </div>
          </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Swift Delivery, Exceptional Service</h5>
                <p class="card-text">Experience the convenience of rapid delivery with our commitment to swift service. At ELECTRO-NACER, we prioritize your time, ensuring that your purchases reach your doorstep with speed and efficiency. Our fast delivery service is designed to exceed expectations, bringing your selected items to you in record time.</p>
                <a href="#" class="btn btn-primary">Learn more</a>
              </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Swift Delivery, Exceptional Service</h5>
                <p class="card-text">Experience the convenience of rapid delivery with our commitment to swift service. At ELECTRO-NACER, we prioritize your time, ensuring that your purchases reach your doorstep with speed and efficiency. Our fast delivery service is designed to exceed expectations, bringing your selected items to you in record time.</p>
                <a href="#" class="btn btn-primary">Learn more</a>
              </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Swift Delivery, Exceptional Service</h5>
                <p class="card-text">Experience the convenience of rapid delivery with our commitment to swift service. At ELECTRO-NACER, we prioritize your time, ensuring that your purchases reach your doorstep with speed and efficiency. Our fast delivery service is designed to exceed expectations, bringing your selected items to you in record time.</p>
                <a href="#" class="btn btn-primary">Learn more</a>
              </div>
            </div>
        </div>

      </div>
    <!-- ABOUT US -->








    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<body>



<script src="assets/js/home.js"></script>
</body>