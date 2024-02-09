<?php
    include "koneksi.php";
    session_start();

    // Pengecekan apakah pengguna memiliki role admin
    if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        $redirect_page = "adminfoto.php";
    } else {
        $redirect_page = "foto.php";
    }

    $fotoid = $_GET['fotoid'];

    $sql = mysqli_query($conn, "DELETE FROM foto WHERE fotoid='$fotoid'");

    header("location: $redirect_page");
?>
