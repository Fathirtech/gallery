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
    <title>Halaman Foto</title>
    <link rel="stylesheet" href="./css/all.min.css">
    <link rel="stylesheet" href="./css/fontawesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans bg-gray-100">
    <div class="bg-white p-4">
    <?php include 'adminnavbar.php'; ?>
        <h1 class="text-3xl text-center text-gray-800">Halaman Foto</h1>
        <p class="text-center mt-2">Selamat datang <b><?=$_SESSION['namalengkap']?></b></p>
    </div>

    <div class="container mx-auto mt-8 p-4">
    <button id="btnTambahfoto" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Upload foto</button>
    <form id="formTambahfoto" action="tambah_foto.php" method="post" enctype="multipart/form-data" class="mb-8" style="display: none;">
        <div class="max-w-md w-full bg-white rounded-lg shadow-md p-6">
            <table class="w-full">
                <tr>
                    <td class="py-2">Judul</td>
                    <td><input type="text" name="judulfoto" class="border p-2 rounded w-full focus:outline-none focus:ring focus:border-blue-300"></td>
                </tr>
                <tr>
                    <td class="py-2">Deskripsi</td>
                    <td><input type="text" name="deskripsifoto" class="border p-2 rounded w-full focus:outline-none focus:ring focus:border-blue-300"></td>
                </tr>
                <tr>
                    <td class="py-2">Lokasi File</td>
                    <td><input type="file" name="lokasifile" class="border p-2 rounded w-full focus:outline-none focus:ring focus:border-blue-300"></td>
                </tr>
                <tr>
                    <td class="py-2">Album</td>
                    <td>
                        <select name="albumid" class="border p-2 rounded w-full focus:outline-none focus:ring focus:border-blue-300">
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
        $sql=mysqli_query($conn,"select * from foto,album where foto.userid='$userid' and foto.albumid=album.albumid");
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
                        $sql2=mysqli_query($conn,"select * from likefoto where fotoid='$fotoid'");
                        echo mysqli_num_rows($sql2);
                    ?>
                </p>
                <div class="flex justify-between items-center mt-4">
                    <a href="hapus_foto.php?fotoid=<?=$data['fotoid']?>" class="text-red-500 hover:underline"><i class="fa-solid fa-trash"></i></a>
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
        // Mengambil nilai input dari form
        var judulFoto = document.getElementsByName("judulfoto")[0].value;
        var deskripsiFoto = document.getElementsByName("deskripsifoto")[0].value;
        var lokasiFile = document.getElementsByName("lokasifile")[0].value;
        
        // Memeriksa apakah setiap input tidak kosong
        if (judulFoto.trim() === '' || deskripsiFoto.trim() === '' || lokasiFile.trim() === '') {
            // Mencegah formulir untuk dikirim
            event.preventDefault();
            // Menampilkan pesan kesalahan
            alert("Semua kolom harus diisi!");
        }
    });
</script>
</body>
</html>
