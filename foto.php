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
    <title>Halaman Foto</title>
    <link rel="stylesheet" href="./css/all.min.css">
    <link rel="stylesheet" href="./css/fontawesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-KyZXEAg3QhqLMpG8r+Knujsl5+z0I5t9zwnlOP6a7tRO0pgdeU4jre0o9W6cd9c3i8a7b/Dmm7vcubGcRtIUUQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="font-sans bg-gray-100">
<?php include 'navbar.php'; ?>
    <div class="bg-white p-4">
        <h1 class="text-3xl text-center text-gray-800">Halaman Foto</h1>
        <p class="text-center mt-2">Selamat datang <b><?=$_SESSION['namalengkap']?></b></p>
    </div>

    <div class="container mx-auto mt-8 p-4">
    <button id="btnTambahfoto" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Unggah foto</button>
    <form id="formTambahfoto" action="tambah_foto.php" method="post" enctype="multipart/form-data" class="mb-8" style="display: none;">
        <div class="max-w-md w-full bg-white rounded-lg shadow-md p-6">
            <table class="w-full">
                <tr>
                    <td class="py-2">Judul</td>
                    <td><input type="text" name="judulfoto" id="judulfoto" class="border p-2 rounded w-full focus:outline-none focus:ring focus:border-blue-300"></td>
                </tr>
                <tr>
                    <td class="py-2">Deskripsi</td>
                    <td><input type="text" name="deskripsifoto" id="deskripsifoto" class="border p-2 rounded w-full focus:outline-none focus:ring focus:border-blue-300"></td>
                </tr>
                <tr>
                    <td class="py-2">Lokasi File</td>
                    <td><input type="file" name="lokasifile" id="lokasifile" class="border p-2 rounded w-full focus:outline-none focus:ring focus:border-blue-300"></td>
                </tr>
                <tr>
                    <td class="py-2">Album</td>
                    <td>
                        <select name="albumid" id="albumid" class="border p-2 rounded w-full focus:outline-none focus:ring focus:border-blue-300">
                            <?php
                                include "koneksi.php";
                                $userid=$_SESSION['userid'];
                                $sql=mysqli_query($conn,"select * from album where userid='$userid'");
                                while($data=mysqli_fetch_array($sql)){
                            ?>
                                <option value="<?=$data['albumid']?>"><?=$data['namaalbum']?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Tambah" class="bg-blue-500 text-white px-4 py-2 rounded cursor-pointer hover:bg-blue-600"></td>
                </tr>
            </table>
        </div>
    </form>
</div>

<div class="container mx-auto mt-8 p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    <?php
        include "koneksi.php";
        $userid=$_SESSION['userid'];
        $sql=mysqli_query($conn,"SELECT * FROM foto,album WHERE foto.userid='$userid' AND foto.albumid=album.albumid ORDER BY foto.tanggalunggah DESC");
        while($data=mysqli_fetch_array($sql)){
    ?>
        <div class="bg-white border rounded-md overflow-hidden shadow-md transform transition-transform ease-in-out hover:scale-105 relative">
            <!-- Container untuk gambar -->
            <div class="relative" style="padding-bottom: 56.25%;">
                <!-- Padding bottom 56.25% untuk membuat rasio 16:9 -->
                <a href="detail.php?fotoid=<?= $data['fotoid'] ?>">
                <img src="gambar/<?=$data['lokasifile']?>" alt="<?=$data['judulfoto']?>" class="absolute inset-0 w-full h-full object-cover rounded-md">
                </a>
            </div>
            <!-- Container untuk teks -->
            <div class="p-4">
                <div class="text-lg font-bold mb-2"><?=$data['judulfoto']?></div>
                <p class="text-sm text-gray-700 mb-2"><?=$data['deskripsifoto']?></p>
                <p class="text-sm text-gray-700 mb-2"> <?=$data['tanggalunggah']?></p>
                <p class="text-sm text-gray-700 mb-2">Album: <?=$data['namaalbum']?></p>
                <p class="text-sm text-gray-700 mb-2">Disukai: 
                    <?php
                        $fotoid=$data['fotoid'];
                        $sql2=mysqli_query($conn,"SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                        echo mysqli_num_rows($sql2);
                    ?>
                </p>
                <div class="flex justify-between items-center mt-4">
                <a href="hapus_foto.php?fotoid=<?= $data['fotoid'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?');" class="text-red-500 hover:underline"><i class="fa-solid fa-trash"></i></a>
                    <a href="edit_foto.php?fotoid=<?=$data['fotoid']?>" class="text-blue-500 hover:underline"><i class="fa-solid fa-pen-to-square"></i></a>
                </div>
            </div>
        </div>
    <?php
        }
    ?>
</div>
<script>
    document.getElementById("btnTambahfoto").addEventListener("click", function() {
        document.getElementById("formTambahfoto").style.display = "block";
    });

    document.getElementById("formTambahfoto").addEventListener("submit", function(event) {
        var judulfoto = document.getElementById("judulfoto").value.trim();
        var deskripsifoto = document.getElementById("deskripsifoto").value.trim();
        var lokasifile = document.getElementById("lokasifile").value.trim();
        
        if (judulfoto === '' || deskripsifoto === '' || lokasifile === '') {
            alert("Semua kolom harus diisi.");
            event.preventDefault();
        }
    });
</script>
</body>
</html>
