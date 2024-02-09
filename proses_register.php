<?php
    include "koneksi.php";

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $namalengkap = $_POST['namalengkap'];
    $alamat = $_POST['alamat'];

    $sql = mysqli_query($conn, "INSERT INTO user (username, password, email, namalengkap, alamat) VALUES ('$username', '$password', '$email', '$namalengkap', '$alamat')");

    if ($sql) {
        header("location:login.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
?>