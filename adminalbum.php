<?php
session_start();
if(!isset($_SESSION['userid'])){
    header("location:login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Album</title>
    <link rel="stylesheet" href="./css/all.min.css">
    <link rel="stylesheet" href="./css/fontawesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans bg-gray-100">
<div class="bg-white p-4">
        <h1 class="text-3xl text-center text-gray-800">Halaman Album</h1>
        <p class="text-center mt-2">Selamat datang <b><?=$_SESSION['namalengkap']?></b></p>
        
        <ul class="flex items-center justify-center mt-4">
            <li class="mr-4"><a href="adminhome.php" class="text-blue-500 hover:underline">Home</a></li>
            <li class="mr-4"><a href="#" class="text-blue-500 hover:underline">Album</a></li>
            <li class="mr-4"><a href="adminfoto.php" class="text-blue-500 hover:underline">Foto</a></li>
            <li class="mr-4"><a href="adminusers.php" class="text-blue-500 hover:underline">Users</a></li>
            <li><a href="logout.php" class="text-red-500 hover:underline">Logout</a></li>
        </ul>
    </div>

    <div class="container mx-auto mt-8 p-4">
    <button id="btnTambahAlbum" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Tambah Album</button>
    <form id="formTambahAlbum" action="tambah_album.php" method="post" class="mb-8" style="display: none;">
            <table class="w-full">
                <tr>
                    <td class="py-2">Nama Album</td>
                    <td><input type="text" name="namaalbum" id="namaalbum" class="border p-2 rounded"></td>
                </tr>
                <tr>
                    <td class="py-2">Deskripsi</td>
                    <td><input type="text" name="deskripsi" id="deskripsi" class="border p-2 rounded"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Tambah" class="bg-blue-500 text-white px-4 py-2 rounded"></td>
                </tr>
            </table>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    <?php
    include "koneksi.php";
    $userid=$_SESSION['userid'];
    $sql=mysqli_query($conn,"select * from album where userid='$userid'");
    while($data=mysqli_fetch_array($sql)){
    ?>
        <div class="bg-white border rounded-md overflow-hidden shadow-md transform transition-transform ease-in-out hover:scale-105">
            <div class="p-4">
                <a href="album_detail.php?albumid=<?= $data['albumid'] ?>" class="block">
                    <h2 class="text-lg font-semibold mb-2"><?= $data['namaalbum'] ?></h2>
                    <p class="text-sm text-gray-700 mb-2"><?= $data['deskripsi'] ?></p>
                    <p class="text-xs text-gray-500">Tanggal dibuat: <?= $data['tanggaldibuat'] ?></p>
                </a>
                <div class="mt-4 flex justify-between">
                    <a href="hapus_album.php?albumid=<?= $data['albumid'] ?>" class="text-red-500 hover:underline"><i class="fa-solid fa-trash"></i></a>
                    <a href="edit_album.php?albumid=<?= $data['albumid'] ?>" class="text-blue-500 hover:underline"><i class="fa-solid fa-pen-to-square"></i></a>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>
<script>
        document.getElementById("btnTambahAlbum").addEventListener("click", function() {
            document.getElementById("formTambahAlbum").style.display = "block";
        });

        document.getElementById("formTambahAlbum").addEventListener("submit", function(event) {
            var namaalbum = document.getElementById("namaalbum").value.trim();
            var deskripsi = document.getElementById("deskripsi").value.trim();
            
            if (namaalbum === '' || deskripsi === '') {
                alert("Semua kolom harus diisi.");
                event.preventDefault();
            }
        });
    </script>
</div>
    </div>
</body>
</html>
