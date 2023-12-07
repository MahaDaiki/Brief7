<?php
include("config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-sm navbar-dark ">
    <div class="container">
        <a href="#" class="navbar-brand">NE</a>
        
        <!-- Add the burger menu button for smaller screens -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="home.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="category.php" class="nav-link">Categories</a>
                </li>
            </ul>

            <img width="48" src="img/user-286-128.png" alt="profile" class="user-pic">

            <div class="menuwrp" id="subMenu">
                <div class="submenu">
                    <div class="userinfo">
                        
                            <div>
                                <a href="logout.php">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

    <div class="container">
        <div class="row">
           
            <div class="col-md-3">
                <div class="list-group">
                    <h3>Category</h3>
                    <div >
                        <?php
                       $query = "SELECT catname, imgs FROM Categories WHERE bl = 1 ORDER BY catname ASC";
                       $result = mysqli_query($conn, $query);
                       
                       while ($row = mysqli_fetch_assoc($result)) {
                       ?>
                           <div class="list-group-item checkbox">
                               <label>
                                   <input type="checkbox" class="common_selector category" value="<?php echo $row['catname']; ?>">
                                    <img src="<?php echo $row['imgs']; ?>" alt="Category Image" style="width: 50px; height: 50px;">
                                   <?php echo $row['catname']; ?>
                                  
                               </label>
                           </div>
                       <?php
                       }
                       ?>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <br />
                <div class="row filter_data">
                </div>
            </div>
        </div>
    </div>

     <script src="index.js"></script>                       
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        function filter_data(page = 1) {
            var action = 'fetch_data';
            var category = get_filter('category');

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "fetch_data.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.querySelector('.filter_data').innerHTML = xhr.responseText;
                }
            };
            xhr.send("action=" + action + "&category=" + JSON.stringify(category) + "&page=" + page);
        }

        function get_filter(class_name) {
            var filter = [];
            var checkboxes = document.querySelectorAll('.' + class_name + ':checked');
            checkboxes.forEach(function (checkbox) {
                filter.push(checkbox.value);
            });
            return filter;
        }

        document.querySelectorAll('.common_selector').forEach(function (selector) {
            selector.addEventListener('change', function () {
                filter_data();
            });
        });

        // Handle pagination click
        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('page-link')) {
                e.preventDefault();
                var page = e.target.getAttribute('data-page');
                filter_data(page);
            }
        });

        // Initial load
        filter_data();
    });
    </script>
</body>

</html>
