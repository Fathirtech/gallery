<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['userid'])) {
    header("location:login.php");
}

if (isset($_GET['albumid'])) {
    $albumid = $_GET['albumid'];
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
    <title>Album Detail</title>
    <link rel="stylesheet" href="./css/all.min.css">
    <link rel="stylesheet" href="./css/fontawesome.min.css">
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
        <h1 class="text-3xl text-center text-gray-800">Album Detail</h1>
        <p class="text-center mt-2">Selamat datang <b><?= $_SESSION['namalengkap'] ?></b></p>
    </div>

    <div class="container mx-auto mt-8 p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php
        include "koneksi.php";
        $userid = $_SESSION['userid'];
        $idAlbum = $_GET["albumid"];
        $sql = mysqli_query($conn, "SELECT foto.*, album.namaalbum FROM foto INNER JOIN album ON foto.albumid = album.albumid WHERE foto.userid='$userid' AND foto.albumid='$idAlbum' ORDER BY foto.tanggalunggah DESC");
        while ($data = mysqli_fetch_array($sql)) {
        ?>
            <div class="bg-white border rounded-md overflow-hidden shadow-md transform transition-transform ease-in-out hover:scale-105 relative">
                <!-- Container untuk gambar -->
                <div class="relative" style="padding-bottom: 56.25%;">
                    <!-- Padding bottom 56.25% untuk membuat rasio 16:9 -->
                    <?php
        // Tentukan URL berdasarkan peran pengguna
        $commentPage = ($_SESSION['role'] === 'admin') ? 'detail.php' : 'detail.php';
    ?>
    <a href="<?= $commentPage ?>?fotoid=<?= $data['fotoid'] ?>">
        <img src="gambar/<?= $data['lokasifile'] ?>" alt="<?= $data['judulfoto'] ?>" class="absolute inset-0 w-full h-full object-cover rounded-md">
    </a>
                </div>
                <!-- Container untuk teks -->
                <div class="p-4">
                    <div class="text-lg font-bold mb-2"><?= $data['judulfoto'] ?></div>
                    <p class="text-sm text-gray-700 mb-2"><?= $data['deskripsifoto'] ?></p>
                    <p class="text-sm text-gray-700 mb-2"> <?= $data['tanggalunggah'] ?></p>
                    <p class="text-sm text-gray-700 mb-2">Album: <?= $data['namaalbum'] ?></p>
                    <p class="text-sm text-gray-700 mb-2">Disukai:
                        <?php
                        $fotoid = $data['fotoid'];
                        $sql2 = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                        echo mysqli_num_rows($sql2);
                        ?>
                    </p>
                    <div class="flex justify-between items-center mt-4">
                        <a href="hapus_foto.php?fotoid=<?= $data['fotoid'] ?>" class="text-red-500 hover:underline"><i class="fa-solid fa-trash"></i></a>
                        <a href="edit_foto.php?fotoid=<?= $data['fotoid'] ?>" class="text-blue-500 hover:underline"><i class="fa-solid fa-pen-to-square"></i></a>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

</body>

</html>
<?php
} else {
    // Check user role to determine the redirection link
    if ($_SESSION['role'] === 'admin') {
        header("location:adminalbum.php");
    } else {
        header("location:album.php");
    }
}
?>
