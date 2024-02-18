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
</head>

<body class="font-sans bg-gray-100">
    <div class="bg-white p-4">
        <h1 class="text-3xl text-center text-gray-800">Selamat Datang di Gallery</h1>
        <?php
        session_start();
        if (!isset($_SESSION['userid'])) {
            ?>
            <div class="flex justify-center mt-4">
                <ul class="flex items-center">
                    <li class="mr-4"><a href="register.php" class="text-blue-500 hover:underline">Register</a></li>
                    <li><a href="login.php" class="text-blue-500 hover:underline">Login</a></li>
                </ul>
            </div>
            <?php
        } else {
            ?>
            <p class="text-center mt-4">Selamat datang <b>
                    <?= $_SESSION['namalengkap'] ?>
                </b></p>
            <ul class="flex items-center justify-center mt-4">
                <li class="mr-4"><a href="#" class="text-blue-500 hover:underline">Home</a></li>
                <li class="mr-4"><a href="adminalbum.php" class="text-blue-500 hover:underline">Album</a></li>
                <li class="mr-4"><a href="adminfoto.php" class="text-blue-500 hover:underline">Foto</a></li>
                <li class="mr-4"><a href="adminusers.php" class="text-blue-500 hover:underline">Users</a></li>
                <li><a href="logout.php" class="text-red-500 hover:underline">Logout</a></li>
            </ul>
            <?php
        }
        ?>
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
        include "koneksi.php";

        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $sql = mysqli_query($conn, "SELECT * FROM foto, user WHERE foto.userid=user.userid AND judulfoto LIKE '%$search%'");

        while ($data = mysqli_fetch_array($sql)) {
            ?>

            <div
                class="bg-white border rounded-md overflow-hidden shadow-md transform transition-transform ease-in-out hover:scale-105 relative">
                <div class="relative" style="padding-bottom: 56.25%;">
                    <a href="admindetail.php?fotoid=<?= $data['fotoid'] ?>">
                        <img src="gambar/<?= $data['lokasifile'] ?>" alt="<?= $data['judulfoto'] ?>"
                            class="absolute inset-0 w-full h-full object-cover rounded-md">
                    </a>

                </div>
                <div class="p-4">
                    <div class="text-lg font-bold mb-2">
                        <?= $data['judulfoto'] ?>
                    </div>
                    <p class="text-sm text-gray-700">
                        <?= $data['deskripsifoto'] ?>
                    </p>
                    <div class="flex justify-between items-center mt-2">
                        <span>
                            <?= $data['namalengkap'] ?>
                        </span>
                        <span>Like
                            <?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid={$data['fotoid']}")); ?>
                        </span>
                    </div>
                    <div class="flex justify-between items-center mt-2">
                        <?php
                        $sql_check_like = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='{$data['fotoid']}' AND userid='{$_SESSION['userid']}'");
                        $liked = mysqli_num_rows($sql_check_like) > 0;
                        $heart_icon_class = $liked ? "fa-solid fa-heart" : "fa-regular fa-heart";
                        $heart_icon_color = $liked ? "text-red-500" : "text-gray-500";
                        ?>
                        <a href="adminlike.php?fotoid=<?= $data['fotoid'] ?>"
                            class="<?= $heart_icon_color ?> hover:underline"><i class="fa <?= $heart_icon_class ?>"></i></a>
                        <a href="admindetail.php?fotoid=<?= $data['fotoid'] ?>" class="text-blue-500 hover:underline"><i
                                class="fa-regular fa-comment"></i></a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

</body>

</html>
