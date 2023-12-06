<?php
session_start();

// Check if the user is logged in and is an admin
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

// Handle delete user request
if (isset($_GET["delete_user"])) {
    $user_id = $_GET["delete_user"];

    // Delete user from the database
    $delete_sql = $conn->prepare("DELETE FROM users WHERE id = ?");
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
    $verify_sql = $conn->prepare("UPDATE users SET valide = 1 WHERE id = ?");
    $verify_sql->bind_param("i", $user_id);
    $verify_sql->execute();

    // Redirect back to the admin panel
    header("Location: adminpan.php");
    exit();
}

if (isset($_GET["promoteadmin"])) {
    $user_admin = $_GET['promoteadmin'];

    // Fetch user details from the users table
    $get_data = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $get_data->bind_param("s", $user_admin);
    $get_data->execute();
    $result = $get_data->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Insert the user into the admins table
        $insert_admin_sql = $conn->prepare("INSERT INTO admins (username, email, passw) VALUES (?, ?, ?)");
        $insert_admin_sql->bind_param("sss", $row['username'], $row['email'], $row['passw']);
        $insert_admin_sql->execute();

        // Delete the user from the users table
        $delete_user_sql = $conn->prepare("DELETE FROM users WHERE email = ?");
        $delete_user_sql->bind_param("s", $row['email']);
        $delete_user_sql->execute();

        header("Location: users.php");
        exit();
    } else {
        echo "User not found!";
    }
}

// Retrieve all for display 
$select_users_sql = "SELECT * FROM users";
$result = $conn->query($select_users_sql);
$select_admins_sql = "SELECT * FROM admins";
$admins_result = $conn->query($select_admins_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body style="background: linear-gradient(to bottom, #6ab1e7,#023364)">
<nav class="navbar navbar-expand-sm navbar-dark ">
    <div class="container">
        <a href="#" class="navbar-brand">NE</a>
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
        <h3 class="mb-4 text-center">Users</h3>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['username']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td>";
                    echo "<a href='adminpan.php?delete_user={$row['id']}' class='btn btn-danger btn-sm mr-2'>Delete</a>";
                    if (isset($row['valide']) && $row['valide'] == 0) {
                        echo "<a href='adminpan.php?verify_user={$row['id']}' class='btn btn-success btn-sm mr-2'>Verify</a>";
                    }
                    echo "<a href='adminpan.php?promoteadmin=" . urlencode($row['email']) . "'><button type='button' class='btn btn-primary'>Promote</button></a>";
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
    </div>
<script src="index.js"></script>
</body>
</html>

<?php
$conn->close();
?>