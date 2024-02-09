<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['userid'])) {
    header("location:login.php");
}

if (isset($_GET['albumid'])) {
    $albumid = $_GET['albumid'];
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
    <style>
        /* Additional CSS styles for full-size image display */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 9999;
        }

        .overlay-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .full-size-img {
            max-width: 90%;
            max-height: 90%;
        }
    </style>
</head>

<body class="font-sans bg-gray-100">
    <div class="bg-white p-4">
        <h1 class="text-3xl text-center text-gray-800">Album Detail</h1>
        <p class="text-center mt-2">Selamat datang <b><?= $_SESSION['namalengkap'] ?></b></p>

        <ul class="flex items-center justify-center mt-4">
            <?php
            // Check user role to determine the redirection link
            if ($_SESSION['role'] === 'admin') {
            ?>
                <li class="mr-4"><a href="adminhome.php" class="text-blue-500 hover:underline">Home</a></li>
                <li class="mr-4"><a href="adminalbum.php" class="text-blue-500 hover:underline">Album</a></li>
                <li class="mr-4"><a href="adminfoto.php" class="text-blue-500 hover:underline">Foto</a></li>
                <li class="mr-4"><a href="adminusers.php" class="text-blue-500 hover:underline">Users</a></li>
            <?php
            } else {
            ?>
                <li class="mr-4"><a href="index.php" class="text-blue-500 hover:underline">Home</a></li>
                <li class="mr-4"><a href="album.php" class="text-blue-500 hover:underline">Album</a></li>
                <li class="mr-4"><a href="foto.php" class="text-blue-500 hover:underline">Foto</a></li>
            <?php
            }
            ?>
            <li><a href="logout.php" class="text-red-500 hover:underline">Logout</a></li>
        </ul>
    </div>

    <div class="container mx-auto mt-8 p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php
        include "koneksi.php";
        $userid = $_SESSION['userid'];
        $sql = mysqli_query($conn, "select * from foto,album where foto.userid='$userid' and foto.albumid=album.albumid");
        while ($data = mysqli_fetch_array($sql)) {
        ?>
            <div class="bg-white border rounded-md overflow-hidden shadow-md transform transition-transform ease-in-out hover:scale-105 relative">
                <!-- Container untuk gambar -->
                <div class="relative" style="padding-bottom: 56.25%;">
                    <!-- Padding bottom 56.25% untuk membuat rasio 16:9 -->
                    <img src="gambar/<?= $data['lokasifile'] ?>" alt="<?= $data['judulfoto'] ?>" class="absolute inset-0 w-full h-full object-cover rounded-md"
                        onclick="openFullSizeImage('gambar/<?= $data['lokasifile'] ?>', '<?= $data['judulfoto'] ?>')">
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
                        $sql2 = mysqli_query($conn, "select * from likefoto where fotoid='$fotoid'");
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

    <!-- Full-size image overlay -->
    <div class="overlay" id="overlay" onclick="closeFullSizeImage()">
        <div class="overlay-content">
            <img src="" alt="" id="fullSizeImage" class="full-size-img">
        </div>
    </div>

    <script>
        function openFullSizeImage(imageUrl, altText) {
            // Set the src and alt attributes of the full-size image
            document.getElementById("fullSizeImage").src = imageUrl;
            document.getElementById("fullSizeImage").alt = altText;
            // Show the overlay
            document.getElementById("overlay").style.display = "block";
        }

        function closeFullSizeImage() {
            // Hide the overlay
            document.getElementById("overlay").style.display = "none";
        }
    </script>
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
