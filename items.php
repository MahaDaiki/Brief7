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
                    <a href="index.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="items.php" class="nav-link">items</a>
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
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <h3>Category</h3>
                <button class="btn btn-danger btn-sm admin-only-button" >Manage</button>
                <div>
                <label>
                        <input type="checkbox" class="common_selector" id="sort_alphabetically"> Sort Alphabetically
                    </label>
                    <label>
    <input type="checkbox" class="common_selector" id="stock_filter"> Stock Filter
</label>
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
            <div class="input-group mb-3">
                <input type="text" id="search" class="form-control" placeholder="Search by product name">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" onclick="searchData()">Search</button>
                </div>
            </div>
            <div class="row filter_data"></div>
            <div class="pagination mt-3" id="pagination-container"></div>
        </div>
    </div>
</div>



<script>
     document.addEventListener("DOMContentLoaded", function () {
    function filter_data(page) {
        var action = 'fetch_data';
        var category = get_filter('category');
        var searchQuery = document.getElementById('search').value.trim();
        var sortAlphabetically = document.getElementById('sort_alphabetically').checked;
        var stockFilter = document.getElementById('stock_filter').checked;

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "fetch_data.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.querySelector('.filter_data').innerHTML = xhr.responseText;
            }
        };

        var data = "action=" + action +
            "&category=" + JSON.stringify(category) +
            "&search_query=" + searchQuery +
            "&sort_alphabetically=" + (sortAlphabetically ? 1 : 0) +
            "&stock_filter=" + (stockFilter ? 1 : 0) +
            "&page=" + page;

        xhr.send(data);
    }
    function updatePaginationLinks(currentPage) {
        var paginationContainer = document.getElementById('pagination');
        if (paginationContainer) {
            paginationContainer.addEventListener('click', function (e) {
                if (e.target.classList.contains('page-link')) {
                    e.preventDefault();
                    var page = e.target.id;
                    filter_data(page);
                }
            });
        }
    }


    function get_filter(class_name) {
        var filter = [];
        var checkboxes = document.querySelectorAll('.' + class_name + ':checked');
        checkboxes.forEach(function (checkbox) {
            filter.push(checkbox.value);
        });

        return filter;
    }

    document.getElementById('search').addEventListener('input', function () {
        filter_data(1); // Reset to the first page when searching
    });

    document.querySelectorAll('.common_selector').forEach(function (selector) {
        selector.addEventListener('change', function () {
            filter_data(1); // Reset to the first page when changing filters
        });
    });

    // Pagination Click
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('page')) {
            var page = e.target.id;
            filter_data(page);
        }
    });

    // Initial load
    filter_data(1);
});

</script> 
<script src="index.js"></script>
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>



 <script src="index.js"></script>
<script src="assets/js/home.js"></script>

</body>

</html>
