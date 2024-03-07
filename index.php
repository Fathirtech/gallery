<?php
session_start();
include "koneksi.php";

$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk menghitung jumlah total hasil pencarian
$total_results_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM foto 
                            INNER JOIN album ON foto.albumid = album.albumid
                            INNER JOIN user ON foto.userid = user.userid 
                            WHERE album.acceslevel = 'public' AND judulfoto LIKE '%$search%'");
$total_results_row = mysqli_fetch_assoc($total_results_query);
$total_results = $total_results_row['total'];

// Jumlah item per halaman
$items_per_page = 12;

// Menghitung jumlah halaman
$total_pages = ceil($total_results / $items_per_page);

// Mendapatkan halaman saat ini
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Mendapatkan offset (mulai dari mana data ditampilkan)
$offset = ($current_page - 1) * $items_per_page;

// Query untuk mendapatkan data foto sesuai dengan halaman saat ini, diurutkan berdasarkan tanggal_upload secara descending
$sql = mysqli_query($conn, "SELECT * FROM foto 
                            INNER JOIN album ON foto.albumid = album.albumid
                            INNER JOIN user ON foto.userid = user.userid 
                            WHERE album.acceslevel = 'public' AND judulfoto LIKE '%$search%' 
                            ORDER BY foto.tanggalunggah DESC LIMIT $items_per_page OFFSET $offset");

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
    <title>Halaman Landing</title>
    <link rel="stylesheet" href="./css/all.min.css">
    <link rel="stylesheet" href="./css/fontawesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome 6 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-KyZXEAg3QhqLMpG8r+Knujsl5+z0I5t9zwnlOP6a7tRO0pgdeU4jre0o9W6cd9c3i8a7b/Dmm7vcubGcRtIUUQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .like-button {
            position: absolute;
            top: -9999px;
            right: -9999px;
            z-index: 1;
            transition: transform 0.3s ease;
        }

        .like-button.show {
            top: 10px;
            right: 10px;
        }

        .like-button:hover {
            transform: scale(1.2);
        }

        .like-icon {
            font-size: 1.5rem;
        }
    </style>
</head>

<body class="font-sans bg-gray-100" >
<?php include 'navbar.php'; ?>
    <div class="bg-white p-4">
        <h1 class="text-3xl text-center text-gray-800">Selamat Datang di MY Gallery</h1>
        <?php if(isset($_SESSION['userid'])): ?>
        <p class="text-center mt-4">Selamat datang <b><?= $_SESSION['namalengkap'] ?></b></p>
        <?php endif; ?>
    </div>

    <!-- Search Form -->
    <div class="container mx-auto mt-4 p-4">
        <form action="" method="GET">
            <div class="flex items-center justify-center">
                <input type="text" name="search" placeholder="Search..."
                    class="border border-gray-300 px-4 py-2 rounded-md">
                <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"><i
                        class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
    </div>

    <div class="container mx-auto mt-8 p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php
        while ($data = mysqli_fetch_array($sql)) {
            ?>
            <div class="relative bg-white border rounded-md overflow-hidden shadow-md transform transition-transform ease-in-out hover:scale-105">
                <!-- Container for image -->
                <div class="relative" style="padding-bottom: 56.25%;">
                    <!-- Padding bottom 56.25% for 16:9 ratio -->
                    <a href="detail.php?fotoid=<?= $data['fotoid'] ?>">
                        <img src="gambar/<?= $data['lokasifile'] ?>" alt="<?= $data['judulfoto'] ?>" class="absolute inset-0 w-full h-full object-cover rounded-md">
                    </a>
                </div>
                <!-- Like button -->
                <div class="like-button">
                    <?php
                    if (isset($_SESSION['userid'])) {
                        $sql_check_like = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='{$data['fotoid']}' AND userid='{$_SESSION['userid']}'");
                        $liked = mysqli_num_rows($sql_check_like) > 0;
                        $heart_icon_class = $liked ? "fa-solid fa-heart text-red-500" : "fa-regular fa-heart text-gray-500";
                        ?>
                        <a href="like.php?fotoid=<?= $data['fotoid'] ?>" class="like-icon"><i class="fa <?= $heart_icon_class ?>"></i></a>
                        <?php
                    } else {
                        // Jika pengguna belum login, munculkan tombol like tetapi non-aktif
                        ?>
                        <a href="login.php" class="like-icon"><i class="fa fa-regular fa-heart text-gray-500"></i></a>
                        <?php
                    }
                    ?>
                </div>
                <!-- Container for text -->
                <div class="p-4">
                    <div class="text-lg font-bold mb-2"><?= $data['judulfoto'] ?></div>
                    <p class="text-sm text-gray-700"><?= $data['deskripsifoto'] ?></p>
                    <div class="flex justify-between items-center mt-2">
                        <span><?= $data['namalengkap'] ?></span>
                        <span>like <?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid={$data['fotoid']}")); ?></span>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

    <!-- Pagination -->
    <div class="container mx-auto mt-8 p-4">
        <ul class="flex justify-center space-x-4">
            <?php
            // Generate pagination links
            for ($page = 1; $page <= $total_pages; $page++) {
                echo '<li><a href="?search=' . $search . '&page=' . $page . '" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">' . $page . '</a></li>';
            }
            ?>
        </ul>
    </div>
    <footer class="bg-gray-800 text-white p-4 text-center">
        <p>&copy; 2024 MY Gallery. All rights reserved.</p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const photoContainers = document.querySelectorAll(".relative");

            photoContainers.forEach(container => {
                container.addEventListener("mouseover", function () {
                    const likeButton = container.querySelector(".like-button");
                    likeButton.classList.add("show");
                });

                container.addEventListener("mouseleave", function () {
                    const likeButton = container.querySelector(".like-button");
                    likeButton.classList.remove("show");
                });
            });
        });
    </script>

</body>

</html>
