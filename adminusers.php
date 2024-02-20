<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
    <!-- Add this line to your head section -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-KyZXEAg3QhqLMpG8r+Knujsl5+z0I5t9zwnlOP6a7tRO0pgdeU4jre0o9W6cd9c3i8a7b/Dmm7vcubGcRtIUUQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="font-sans bg-gray-100">
    <div class="bg-white p-4">
        <?php
        session_start();
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        ?>
            <?php include 'adminnavbar.php'; ?>
            <h1 class="text-3xl text-center text-gray-800">Halaman User</h1>
            <p class="text-center mt-2">Selamat datang <b><?=$_SESSION['namalengkap']?></b></p>
        <?php
        } else {
            header("Location: index.php"); // Redirect if not an admin
            exit();
        }
        ?>
    </div>

    <div class="container mx-auto mt-8 p-4">
        <!-- Search Form -->
        <form action="" method="get" class="mb-4">
            <input type="text" name="search" placeholder="Search by Username" class="border p-2 rounded">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
        </form>

        <!-- User Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <?php
            include "koneksi.php";

            // Check if the search parameter is set
            if (isset($_GET['search'])) {
                $search = mysqli_real_escape_string($conn, $_GET['search']);
                $result = mysqli_query($conn, "SELECT * FROM user WHERE username LIKE '%$search%'");
            } else {
                // If no search parameter, fetch all users
                $result = mysqli_query($conn, "SELECT * FROM user");
            }

            while ($userData = mysqli_fetch_assoc($result)) {
            ?>
                <div class="bg-white border rounded-md overflow-hidden shadow-md transform transition-transform ease-in-out hover:scale-105">
                    <!-- Customize the content based on user data -->
                    <div class="p-4">
                        <div class="text-lg font-bold mb-2"><?= $userData['namalengkap'] ?></div>
                        <p class="text-sm text-gray-700">Username: <?= $userData['username'] ?></p>
                        <p class="text-sm text-gray-700">Email: <?= $userData['email'] ?></p>
                        <p class="text-sm text-gray-700">Address: <?= $userData['alamat'] ?></p>
                        <p class="text-sm text-gray-700">Type: <?= $userData['role'] ?></p>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>
