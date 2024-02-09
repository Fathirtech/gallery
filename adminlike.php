<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['userid'])) {
    // Untuk bisa like harus login dulu
    header("location:adminhome.php");
} else {
    $fotoid = $_GET['fotoid'];
    $userid = $_SESSION['userid'];

    // Cek apakah user sudah pernah like foto ini apa belum
    $sql = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");

    if (mysqli_num_rows($sql) == 1) {
        // User sudah pernah like foto ini, hapus like
        mysqli_query($conn, "DELETE FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
    } else {
        // User belum pernah like foto ini, tambahkan like
        $tanggallike = date("Y-m-d");
        // Assuming likeid is an auto-incremented column and doesn't need to be explicitly set
        mysqli_query($conn, "INSERT INTO likefoto (fotoid, userid, tanggallike) VALUES ('$fotoid', '$userid', '$tanggallike')");
    }
    header("location:adminhome.php");
}
?>
