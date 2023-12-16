<?php
if (isset($_POST['btn'])) {
    include_once 'config.php';

    $i = $_POST['i'];

    for ($j=0; $j < $i; $j++) {
        $uploadDir = 'uploads/';
        $isadmin = 0; // announcer by default

        $originalFileName = $_FILES['avatar-' . $j]['name'];
        $uploadFile = $uploadDir . basename($originalFileName);
        move_uploaded_file($_FILES['avatar-' . $j]['tmp_name'], $uploadFile);

        if ($_POST['is_admin-' . $j] === 'admin') {
            $isadmin = 1;
        }
        $queryiNSERT = "INSERT INTO users VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
        $stm = $connect->prepare($queryiNSERT);
        $stm->bind_param('ssssssi', $_POST['firstname-' . $j],$_POST['lastname-' . $j],
         $_POST['username-' . $j], $_POST['email-' . $j], $_POST['password-' . $j], $uploadFile, $isadmin);
        $rslt = $stm->execute();
        if (!$rslt){
            echo 'error : ' . mysqli_errno($connect);
        } else {
            header('location: index.php');
        }
    }
}
?>