<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["admin_username"])) {
    header("Location: index.php");
    exit();
}


include("config.php");

// Function to fetch all categories
function fetchCategories() {
    global $conn;
    $sql = "SELECT * FROM Categories WHERE bl=true"; 
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Function to display category details in a form
function displayCategoryDetails($categoryName) {
    global $conn;
    $sql = "SELECT * FROM Categories WHERE catname = '$categoryName'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

// Function to update category details
function updateCategory($categoryName, $description, $imagePath) {
    global $conn;
    $sql = "UPDATE Categories SET descrip='$description', imgs='$imagePath' WHERE catname='$categoryName'";

    return $conn->query($sql);
}


function deleteCategory($categoryName) {
    global $conn;
    $sql = "UPDATE Categories SET bl=false WHERE catname='$categoryName'";

    return $conn->query($sql);
}

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $loopCount = count($_POST['catname']); 

    for ($i = 0; $i < $loopCount; $i++) {
        $catname = $_POST['catname'][$i];
        $descrip = $_POST['descrip'][$i];
      
        // Handle image upload
        $imagePath = "img/";
        $imageFileName = $_FILES['imgs']['name'][$i];
    $imageFilePath = $imagePath . $imageFileName;

    move_uploaded_file($_FILES['imgs']['tmp_name'][$i], $imageFilePath);

    $sql = "INSERT INTO Categories (catname, descrip, imgs, bl) VALUES ('$catname', '$descrip', '$imageFilePath', 1)";

        
        if (mysqli_query($conn, $sql)) {
            echo "<script type='text/javascript'>alert('New category added successfully!');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    $categories = fetchCategories();  

$conn->close();
   
}

if (isset($_GET['delete_category'])) {
    $categoryName = $_GET['delete_category'];
    if (deleteCategory($categoryName)) {
        echo  "<script type='text/javascript'>alert('Category deleted successfully!');</script>";
    } else {
        echo "Error deleting category: " . $conn->error;
    }
}

// Display a list of categories with options to modify or delete
$categories = fetchCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body style="background:  #6ab1e7">
<nav class="navbar navbar-expand-sm navbar-dark ">
    <div class="container">
      <a href="#" class="navbar-brand">NE</a>
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
            <?php
           
            
            // Check if an admin is logged in
            if (isset($_SESSION["admin_username"])) {
              $displayName = $_SESSION["admin_username"];
              $isAdmin = true;
            } elseif (isset($_SESSION["username"])) {
              $displayName = $_SESSION["username"];
              $isAdmin = false;
            } else {
              // Redirect to the login page if neither admin nor user is logged in
              header("Location: index.php");
              exit();
            }
            ?>
            <div class="userinfo">
              <img src="img/user-286-128.png" alt="user">
              <h2>
                <?php echo $displayName; ?>
              </h2>
              <hr>
              <?php
                    if ($isAdmin) {
                        echo '<a href="adminpan.php">Admin Panel</a>';
                    }
                    ?>
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

  <div class="container mt-5">
        <h2 class="mb-4">Manage Categories</h2>

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category) { ?>
                    <tr>
                        <td><?php echo $category['catname']; ?></td>
                        <td><?php echo $category['descrip']; ?></td>
                        <td><img src="<?php echo $category['imgs']; ?>" alt="Category Image" style="max-width: 100px;"></td>
                        <td>
                            <a href="edit_category.php?category_name=<?php echo $category['catname']; ?>">Edit</a>
                            |
                            <a href="?delete_category=<?php echo $category['catname']; ?>"
                                onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

       <div class="container formedit bg-light col-8 mt-5 rounded py-2">
    <h3 class="mt-4 d-flex justify-content-center">Add Categories</h3>
    <form method="post" action="" enctype="multipart/form-data">
        <div class="items-container">
            <div class="item">
                <div class="form-group">
                    <label for="new_category_name">Category Name:</label>
                    <input type="text" class="form-control" name="catname[]" required>
                </div>
                <div class="form-group">
                    <label for="new_description">Description:</label>
                    <textarea class="form-control" name="descrip[]" required></textarea>
                </div>
                <div class="form-group">
                    <label for="new_image">Image:</label>
                    <input type="file" class="form-control-file" name="imgs[]">
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <button type="button" class="btn btn-primary " id="add-category-btn">Add Another Category</button>
            <button type="submit" class="btn btn-danger mx-5" name="add">Add Categories</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var addCategoryButton = document.getElementById("add-category-btn");
        var itemsContainer = document.querySelector(".items-container");
        var firstItem = itemsContainer.querySelector(".item");

        addCategoryButton.addEventListener("click", function () {
            var newItem = firstItem.cloneNode(true);
            newItem.querySelectorAll("input, textarea").forEach(function (element) {
                element.value = "";
            });
            itemsContainer.appendChild(newItem);
        });
    });
</script>




    <script src="index.js"></script>
</body>

</html>