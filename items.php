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


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function filter_data() {
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
                xhr.send("action=" + action + "&category=" + JSON.stringify(category));
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

            // Initial load
            filter_data();
        });
    </script>
</body>

</html>
