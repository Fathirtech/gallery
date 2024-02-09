<?php
    include "koneksi.php";
    session_start();

    $albumid = $_POST['albumid'];
    $namaalbum = $_POST['namaalbum'];
    $deskripsi = $_POST['deskripsi'];

    $sql = mysqli_query($conn, "UPDATE album SET namaalbum='$namaalbum', deskripsi='$deskripsi' WHERE albumid='$albumid'");

    // Check if the user has the role of admin
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        header("location: adminalbum.php");
    } else {
        header("location: album.php");
    }
?>
