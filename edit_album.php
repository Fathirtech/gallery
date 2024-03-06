<?php

include "./koneksi.php";

session_start();
if(!isset($_SESSION['userid'])){
    header("location:login.php");
}

function getUserProfile($conn, $userid)
{
    $query = mysqli_query($conn, "SELECT * FROM user WHERE userid = $userid");
    return mysqli_fetch_assoc($query);
}

$user = isset($_SESSION['userid']) ? getUserProfile($conn, $_SESSION['userid']) : null;

// Proses update jika ada POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $albumid = $_POST['albumid'];
    $namaalbum = $_POST['namaalbum'];
    $deskripsi = $_POST['deskripsi'];
    $acceslevel = $_POST['acceslevel'];

    $sql = "UPDATE album SET namaalbum='$namaalbum', deskripsi='$deskripsi', acceslevel='$acceslevel' WHERE albumid='$albumid'";
    if (mysqli_query($conn, $sql)) {
        echo "Album berhasil diperbarui";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Edit Album</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans bg-gray-100">
    <div class="bg-white p-4">
        <ul class="flex items-center justify-center mt-4">
            <?php
            // Check user role to determine the redirection link
            if ($_SESSION['role'] === 'admin') {
                include 'adminnavbar.php';
            } else {
                include 'navbar.php';
            }
            ?>
        </ul>
        <h1 class="text-3xl text-center text-gray-800">Halaman Edit Album</h1>
        <p class="text-center mt-2">Selamat datang <b><?=$_SESSION['namalengkap']?></b></p>
    </div>

    <form action="" method="post" class="container mx-auto mt-8 p-4 flex justify-center">
    <div class="max-w-md w-full">
        <?php
            include "koneksi.php";
            $albumid=$_GET['albumid'];
            $sql=mysqli_query($conn,"SELECT * FROM album WHERE albumid='$albumid'");
            while($data=mysqli_fetch_array($sql)){
        ?>
        <input type="text" name="albumid" value="<?=$data['albumid']?>" hidden>
        <table class="w-full">
            <tr>
                <td class="py-2">Nama Album</td>
                <td><input type="text" name="namaalbum" value="<?=$data['namaalbum']?>" class="border p-2 rounded"></td>
            </tr>
            <tr>
                <td class="py-2">Deskripsi</td>
                <td><input type="text" name="deskripsi" value="<?=$data['deskripsi']?>" class="border p-2 rounded"></td>
            </tr>
            <tr>
                <td class="py-2">Akses Level</td>
                <td>
                    <select name="acceslevel" class="border p-2 rounded">
                        <option value="private" <?php if($data['acceslevel'] === 'private') echo 'selected'; ?>>Private</option>
                        <option value="public" <?php if($data['acceslevel'] === 'public') echo 'selected'; ?>>Public</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Ubah" class="bg-blue-500 text-white px-4 py-2 rounded"></td>
            </tr>
        </table>
        <?php
            }
        ?>
    </div>
</form>

</body>
</html>
