<?php
    include "koneksi.php";
    session_start();

    $namaalbum = $_POST['namaalbum'];
    $deskripsi = $_POST['deskripsi'];
    $tanggaldibuat = date("Y-m-d");
    $userid = $_SESSION['userid'];

    $sql = mysqli_query($conn, "INSERT INTO album (namaalbum, deskripsi, tanggaldibuat, userid) VALUES ('$namaalbum', '$deskripsi', '$tanggaldibuat', '$userid')");

    if ($sql) {
        if ($_SESSION['role'] == 'admin') {
            header("location:adminalbum.php"); // Redirect admin to adminalbum.php
        } else {
            header("location:album.php"); // Redirect other users to album.php
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
?>