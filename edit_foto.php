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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Edit Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans bg-gray-100">
    <div class="bg-white p-4">
    <ul class="flex items-center justify-center mt-4">
            <?php
            // Check user role to determine the redirection link
            if ($_SESSION['role'] === 'admin') {
                ?>
                <?php include 'adminnavbar.php'; ?>
                <?php
            } else {
                ?>
                <?php
                include 'navbar.php';
                ?>
                <?php
            }
            ?>
        </ul>
        <h1 class="text-3xl text-center text-gray-800">Halaman Edit Foto</h1>
        <p class="text-center mt-2">Selamat datang <b><?=$_SESSION['namalengkap']?></b></p>
        
        
    </div>

    <form action="update_foto.php" method="post" enctype="multipart/form-data" class="container mx-auto mt-8 p-4 flex justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-6">
        <input type="hidden" name="fotoid" value="<?php echo $_GET['fotoid'];?>">
        <?php
            include "koneksi.php";
            $fotoid=$_GET['fotoid'];
            $sql=mysqli_query($conn,"select * from foto where fotoid='$fotoid'");
            while($data=mysqli_fetch_array($sql)){
        ?>
        <input type="text" name="fotoid" value="<?=$data['fotoid']?>" hidden>
        <div class="mb-4">
            <label for="judul" class="block text-gray-700 text-sm font-bold mb-2">Judul</label>
            <input type="text" name="judulfoto" id="judul" value="<?=$data['judulfoto']?>" class="border p-2 rounded w-full focus:outline-none focus:ring focus:border-blue-300">
        </div>
        <div class="mb-4">
            <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
            <input type="text" name="deskripsifoto" id="deskripsi" value="<?=$data['deskripsifoto']?>" class="border p-2 rounded w-full focus:outline-none focus:ring focus:border-blue-300">
        </div>
        <div class="mb-4">
            <label for="lokasi" class="block text-gray-700 text-sm font-bold mb-2">Lokasi File</label>
            <input type="file" name="lokasifile" id="lokasi" class="border p-2 rounded w-full focus:outline-none focus:ring focus:border-blue-300">
        </div>
        <div class="mb-4">
            <label for="album" class="block text-gray-700 text-sm font-bold mb-2">Album</label>
            <select name="albumid" id="album" class="border p-2 rounded w-full focus:outline-none focus:ring focus:border-blue-300">
                <?php
                    $userid=$_SESSION['userid'];
                    $sql2=mysqli_query($conn,"select * from album where userid='$userid'");
                    while($data2=mysqli_fetch_array($sql2)){
                ?>
                    <option value="<?=$data2['albumid']?>" <?php if($data2['albumid']==$data['albumid']){echo 'selected';}?>><?=$data2['namaalbum']?></option>
                <?php
                    }
                ?>
            </select>
        </div>
        <div class="flex justify-end">
            <input type="submit" value="Ubah" class="bg-blue-500 text-white px-4 py-2 rounded cursor-pointer hover:bg-blue-600">
        </div>
        <?php
            }
        ?>
    </div>
</form>


</body>
</html>
