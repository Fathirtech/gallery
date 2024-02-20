<?php
    include "koneksi.php";
    session_start();

    $judulfoto = $_POST['judulfoto'];
    $deskripsifoto = $_POST['deskripsifoto'];
    $albumid = $_POST['albumid'];
    $tanggalunggah = date("Y-m-d");
    $userid = $_SESSION['userid'];

    $rand = rand();
    $filename = $_FILES['lokasifile']['name'];
    $ukuran = $_FILES['lokasifile']['size'];
    
    // Hapus pemeriksaan ekstensi
    // $ekstensi =  array('png', 'jpg', 'jpeg', 'gif');
    // $ext = pathinfo($filename, PATHINFO_EXTENSION);
    // if (!in_array($ext, $ekstensi)) {
    //     header("location:foto.php");
    // } else {
    
    // Pemeriksaan ukuran file
    // Ubah batas ukuran menjadi 5 MB (5 * 1024 * 1024)
    if ($ukuran < 5242880) { // Ubah batas ukuran		
        $xx = $rand . '_' . $filename;
        move_uploaded_file($_FILES['lokasifile']['tmp_name'], 'gambar/' . $rand . '_' . $filename);
        // Menggunakan nilai '1' untuk role admin
        $role = isset($_SESSION['role']) && $_SESSION['role'] == 'admin' ? '1' : '0';
        mysqli_query($conn, "INSERT INTO foto VALUES(NULL, '$judulfoto', '$deskripsifoto', '$tanggalunggah', '$xx', '$albumid', '$userid', '$role')");
        // Mengarahkan ke adminfoto.php jika role adalah admin
        if ($role == '1') {
            header("location: adminfoto.php");
        } else {
            header("location: foto.php");
        }
    } else {
        header("location:foto.php");
    }
?>
