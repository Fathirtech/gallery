<?php
    include "koneksi.php";
    session_start();

    $albumid = $_GET['albumid'];

    $sql = mysqli_query($conn, "DELETE FROM album WHERE albumid='$albumid'");

    // Memeriksa role pengguna
    if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        header("location: adminalbum.php");
    } else {
        header("location: album.php");
    }
?>
