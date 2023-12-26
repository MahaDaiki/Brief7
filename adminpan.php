<?php
session_start();

//Check if the user is logged in and is an admin
if (isset($_SESSION["admin_username"])) {
    $isAdmin = true;
} elseif (isset($_SESSION["username"])) {
    $isAdmin = false;
} else {
    header("Location: index.php");
    exit();
}

// Establish a database connection (replace these with your actual database details)
require_once("config.php");

// Handle delete clients request
if (isset($_GET["delete_user"])) {
    $user_id = $_GET["delete_user"];

    // Delete client from the database
    $delete_sql = $conn->prepare("DELETE FROM clients WHERE id = ?");
    $delete_sql->bind_param("i", $user_id);
    $delete_sql->execute();

    // Redirect back to the admin panel
    header("Location: adminpan.php");
    exit();
}

// Handle verify user request
if (isset($_GET["verify_user"])) {
    $user_id = $_GET["verify_user"];

    // Update user's valide status to 1 (true)
    $verify_sql = $conn->prepare("UPDATE clients SET valide = 1 WHERE id = ?");
    $verify_sql->bind_param("i", $user_id);
    $verify_sql->execute();

    // Redirect back to the admin panel
    header("Location: adminpan.php");
    exit();
}
// Handle unverify user request
if (isset($_GET["unverify_user"])) {
    $user_id = $_GET["unverify_user"];

    // Update user's valide status to 1 (true)
    $verify_sql = $conn->prepare("UPDATE clients SET valide = 0 WHERE id = ?");
    $verify_sql->bind_param("i", $user_id);
    $verify_sql->execute();

    // Redirect back to the admin panel
    header("Location: adminpan.php");
    exit();
}


// Retrieve all for display 
//$select_users_sql = "SELECT * FROM users";
$client_result = $conn->query("SELECT * FROM clients");
//$select_admins_sql = "SELECT * FROM admins";
$admins_result = $conn->query("SELECT * FROM admins");
$order_result = $conn->query("SELECT orders.id, orders.creation_date, clients.fullname 
                                FROM orders  INNER JOIN clients 
                                ON orders.client_id=clients.id");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

</head>
<!--style="background: linear-gradient(to bottom, #6ab1e7,#023364)"-->
<body>
<nav class="navbar navbar-expand-sm navbar-dark ">
    <div class="container">
        <a href="#" class="navbar-brand">NE</a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="index.php" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="items.php" class="nav-link">Items</a>
            </li>
        </ul>

        <img width="48" src="img/user-286-128.png" alt="profile" class="user-pic">

        <div class="menuwrp" id="subMenu">
            <div class="submenu">
                <div class="userinfo">
                    <?php
                        if (isset($_SESSION["admin_username"])) {
                            $displayName = $_SESSION["admin_username"];
                            $isAdmin = true;
                        } elseif (isset($_SESSION["username"])) {
                            $displayName = $_SESSION["username"];
                            $isAdmin = false;
                        } else {
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
  </nav>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Admin Panel</h2>
        <h3 class="mb-4 text-center">Clients</h3>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($client_row = $client_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$client_row['id']}</td>";
                    echo "<td>{$client_row['username']}</td>";
                    echo "<td>{$client_row['email']}</td>";
                    if ($client_row['valide']==0){
                        echo "<td>unvalide</td>";
                    }else{
                        echo "<td>valide</td>";
                    }
                    echo "<td>";
                    echo "<a href='adminpan.php?delete_user={$client_row['id']}' class='btn btn-danger btn-sm mr-2'>Delete</a>";
                    if (isset($client_row['valide']) && $client_row['valide'] == 0) {
                        echo "<a href='adminpan.php?verify_user={$client_row['id']}' class='btn btn-success btn-sm mr-2'>Verify</a>";
                    }
                    if (isset($client_row['valide']) && $client_row['valide'] == 1) {
                        echo "<a href='adminpan.php?unverify_user={$client_row['id']}' class='btn btn-warning btn-sm mr-2'>Unverify</a>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="container mt-5">
        <h3 class="mt-5 text-center">Admins</h3>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($admin_row = $admins_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$admin_row['id']}</td>";
                    echo "<td>{$admin_row['username']}</td>";
                    echo "<td>{$admin_row['email']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="container mt-5">
        <h3 class="mt-5 text-center">Orders</h3>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <td>Order</td>
                    <td>order's date</td>
                    <td>client name</td>
                    <td>detail</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($order_row = $order_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$order_row['id']}</td>";
                        echo "<td>{$order_row['creation_date']}</td>";
                        echo "<td>{$order_row['fullname']}</td>";
                        echo "<td>";
                        echo "<a href='order_detail.php?reference={$order_row['id']}' class='btn btn-info btn-sm mr-2'>Detail</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
    
    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>