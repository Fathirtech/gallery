<?php
    include "koneksi.php";
    session_start();

    // Memeriksa apakah pengguna telah login
    if (!isset($_SESSION['userid'])) {
        header("location: login.php");
    }

    $userid = $_SESSION["userid"];
    $fotoid = $_POST["fotoid"];
    $judulfoto = $_POST['judulfoto'];
    $deskripsifoto = $_POST['deskripsifoto'];
    $albumid = $_POST['albumid'];

    // Memeriksa apakah pengguna memiliki role admin
    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        $redirect_page = "adminfoto.php"; // Jika role admin, arahkan ke adminfoto.php
    } else {
        $redirect_page = "foto.php"; // Jika bukan admin, arahkan ke foto.php
    }

    //Jika Upload gambar baru
    if ($_FILES['lokasifile']['name'] != "") {
        $rand = rand();
        // $ekstensi =  array('png', 'jpg', 'jpeg', 'gif'); // Hapus pemeriksaan ekstensi
        $filename = $_FILES['lokasifile']['name'];
        $ukuran = $_FILES['lokasifile']['size'];
        // $ext = pathinfo($filename, PATHINFO_EXTENSION); // Hapus pemeriksaan ekstensi

        // Hapus pemeriksaan ekstensi
        // if (!in_array($ext, $ekstensi)) {
        //     header("location:" . $redirect_page);
        // } else {
        
        // Pemeriksaan ukuran file
        // Ubah batas ukuran menjadi 5 MB (5 * 1024 * 1024)
        if ($ukuran < 5242880) { // Ubah batas ukuran
            $xx = $rand . '_' . $filename;
            move_uploaded_file($_FILES['lokasifile']['tmp_name'], 'gambar/' . $rand . '_' . $filename);
            mysqli_query($conn, "UPDATE foto SET judulfoto='$judulfoto', deskripsifoto='$deskripsifoto', lokasifile='$xx', albumid='$albumid' WHERE fotoid=$fotoid AND userid=$userid");
            header("location:" . $redirect_page);
        } else {
            header("location:" . $redirect_page);
        }
    } else {
        mysqli_query($conn, "UPDATE foto SET judulfoto='$judulfoto', deskripsifoto='$deskripsifoto', albumid='$albumid' WHERE fotoid='$fotoid' AND userid='$userid'");
        header("location:" . $redirect_page);
    }
?>
