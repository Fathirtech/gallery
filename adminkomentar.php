<?php
session_start();
include "koneksi.php";

// Fungsi untuk menghapus komentar
function hapusKomentar($komentarid)
{
    global $conn;
    $query = "DELETE FROM komentarfoto WHERE komentarid='$komentarid'";
    mysqli_query($conn, $query);
}

if (isset($_GET['fotoid'])) {
    $fotoid = $_GET['fotoid'];

    // Proses penambahan komentar
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['isikomentar'])) {
            $isikomentar = $_POST['isikomentar'];
            $userid = $_SESSION['userid'];
            $tgl=date('Y-m-d');
            // Insert komentar
            mysqli_query($conn, "INSERT INTO komentarfoto (fotoid, userid, isikomentar, tanggalkomentar) VALUES ('$fotoid', '$userid', '$isikomentar', '$tgl')");
        }
    }

    // Proses penghapusan komentar
    if (isset($_GET['hapus']) && isset($_GET['komentarid'])) {
        $komentarid = $_GET['komentarid'];
        hapusKomentar($komentarid);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Komentar</title>
    <link rel="stylesheet" href="./css/all.min.css">
    <link rel="stylesheet" href="./css/fontawesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="font-sans bg-gray-100">
    <div class="bg-white p-4">
        <h1 class="text-3xl text-center text-gray-800">Halaman Komentar</h1>
        <p class="text-center mt-4">Selamat datang <b><?=$_SESSION['namalengkap']?></b></p>
            <ul class="flex items-center justify-center mt-4">
                <li class="mr-4"><a href="adminhome.php" class="text-blue-500 hover:underline">Home</a></li>
                <li class="mr-4"><a href="adminalbum.php" class="text-blue-500 hover:underline">Album</a></li>
                <li class="mr-4"><a href="adminfoto.php" class="text-blue-500 hover:underline">Foto</a></li>
                <li class="mr-4"><a href="#" class="text-blue-500 hover:underline">Users</a></li>
                <li><a href="logout.php" class="text-red-500 hover:underline">Logout</a></li>
            </ul>
    </div>

    <div class="container mx-auto mt-8 p-4">
    <form action="" method="post" class="mb-8">
        <?php
        $sql = mysqli_query($conn, "select * from foto where fotoid='$fotoid'");
        while ($data = mysqli_fetch_array($sql)) {
        ?>
            <input type="text" name="fotoid" value="<?=$data['fotoid']?>" hidden>
            <div class="bg-white shadow-md rounded-lg p-4">
                <img src="gambar/<?=$data['lokasifile']?>" width="100%" class="mb-4 rounded-lg">
                <h2 class="text-xl font-semibold mb-4"><?=$data['judulfoto']?></h2>
                <p class="mb-4"><?=$data['deskripsifoto']?></p>

                <div class="flex items-center mb-4">
                    <input type="text" name="isikomentar" placeholder="Tambah komentar" class="border p-2 rounded-lg w-full">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg ml-4"><i class="fa-solid fa-paper-plane"></i></button>
                </div>
            </div>
        <?php
        }
        ?>
    </form>

    <div class="bg-white shadow-md rounded-lg p-4">
        <h2 class="text-xl font-semibold mb-4">Komentar</h2>
        <div class="divide-y divide-gray-200">
            <?php
            $userid = $_SESSION['userid'];
            $sql = mysqli_query($conn, "select komentarfoto.*, user.namalengkap from komentarfoto inner join user on komentarfoto.userid=user.userid where komentarfoto.fotoid='$fotoid'");
            while ($data = mysqli_fetch_array($sql)) {
            ?>
                <div class="flex items-start py-4">
                    <div class="flex-shrink-0">
                        <img src="https://via.placeholder.com/40" alt="Avatar" class="w-10 h-10 rounded-full">
                    </div>
                    <div class="ml-4">
                        <p class="font-semibold"><?=$data['namalengkap']?></p>
                        <p class="text-sm text-gray-400"><?=$data['tanggalkomentar']?></p>
                        <p class="text-gray-600">
                            <?=$data['isikomentar']?><?php if($data['userid'] === $_SESSION['userid']): ?>
                            <a href="?fotoid=<?=$fotoid?>&hapus=true&komentarid=<?=$data['komentarid']?>" class="text-red-500 hover:underline"><i class="fa-solid fa-trash"></i></a>
                        <?php endif; ?>
                    </p>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

</body>

</html>
