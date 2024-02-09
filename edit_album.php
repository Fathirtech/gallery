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
    <title>Halaman Edit Album</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans bg-gray-100">
    <div class="bg-white p-4">
        <h1 class="text-3xl text-center text-gray-800">Halaman Edit Album</h1>
        <p class="text-center mt-2">Selamat datang <b><?=$_SESSION['namalengkap']?></b></p>
        
        <ul class="flex items-center justify-center mt-4">
            <li class="mr-4"><a href="index.php" class="text-blue-500 hover:underline">Home</a></li>
            <li class="mr-4"><a href="album.php" class="text-blue-500 hover:underline">Album</a></li>
            <li class="mr-4"><a href="foto.php" class="text-blue-500 hover:underline">Foto</a></li>
            <li><a href="logout.php" class="text-red-500 hover:underline">Logout</a></li>
        </ul>
    </div>

    <form action="update_album.php" method="post" class="container mx-auto mt-8 p-4 flex justify-center">
    <div class="max-w-md w-full">
        <?php
            include "koneksi.php";
            $albumid=$_GET['albumid'];
            $sql=mysqli_query($conn,"select * from album where albumid='$albumid'");
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
