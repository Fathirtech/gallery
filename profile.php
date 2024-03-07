<?php
session_start(); // Panggil session_start() di bagian atas file sebelum output HTML dimulai
include "koneksi.php";

// Fungsi untuk mendapatkan informasi profil pengguna
function getUserProfile($conn, $userid)
{
    $query = mysqli_query($conn, "SELECT * FROM user WHERE userid = $userid");
    return mysqli_fetch_assoc($query);
}

// Fungsi untuk memperbarui informasi profil pengguna
function updateUserProfile($conn, $userid, $username, $fullname, $email, $address, $profile_photo)
{
    // Cek apakah ada file foto yang diunggah
    if(!empty($profile_photo['name'])) {
        // Simpan foto ke direktori tertentu (misalnya, 'uploads/')
        $target_dir = "gambar/";
        $target_file = $target_dir . basename($profile_photo["name"]);
        move_uploaded_file($profile_photo["tmp_name"], $target_file);
        
        // Update informasi profil dengan nama file foto
        $query = "UPDATE user SET username='$username', namalengkap='$fullname', email='$email', alamat='$address', profile_photo='$target_file' WHERE userid='$userid'";
        mysqli_query($conn, $query);
    } else {
        // Jika tidak ada foto yang diunggah, lakukan pembaruan tanpa mengubah foto profil
        $query = "UPDATE user SET username='$username', namalengkap='$fullname', email='$email', alamat='$address' WHERE userid='$userid'";
        mysqli_query($conn, $query);
    }
}

// Fungsi untuk menghitung jumlah foto yang diunggah oleh pengguna
function countUserUploadedPhotos($conn, $userid)
{
    $query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM foto WHERE userid = $userid");
    $result = mysqli_fetch_assoc($query);
    return $result['total'];
}

// Proses pembaruan informasi profil jika data dikirimkan melalui POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan pengguna sudah login sebelum mengakses halaman ini
    if (!isset($_SESSION['userid'])) {
        header("Location: login.php");
        exit();
    }

    // Ambil data dari formulir
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $profile_photo = $_FILES['profile_photo']; // Ambil file foto profil
    // Ambil userid dari sesi
    $userid = $_SESSION['userid'];

    // Update informasi profil di database
    updateUserProfile($conn, $userid, $username, $fullname, $email, $address, $profile_photo);

    // Simpan informasi pengguna yang diperbarui ke dalam session
    $_SESSION['username'] = $username;
    $_SESSION['namalengkap'] = $fullname;
    $_SESSION['email'] = $email;
    $_SESSION['alamat'] = $address;

    // Redirect kembali ke halaman profil setelah pembaruan
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Ambil informasi profil pengguna
$user = isset($_SESSION['userid']) ? getUserProfile($conn, $_SESSION['userid']) : null;

// Ambil jumlah foto yang diunggah oleh pengguna
$total_photos = isset($_SESSION['userid']) ? countUserUploadedPhotos($conn, $_SESSION['userid']) : 0;



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Tambahkan CSS untuk popup */
        .popup-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            justify-content: center;
            align-items: center;
        }

        .popup {
            background-color: white;
            width: 80%;
            max-width: 400px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
<ul class="flex justify-end">
            <?php
            // Check user role to determine the redirection link
            if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                ?>
                <?php include 'adminnavbar.php'; ?>
                <?php
            } else {
                ?>
                <?php include 'navbar.php'; ?>
                <?php
            }
            ?>
        </ul>
    <div class="bg-white p-4">
        <h1 class="text-3xl text-center text-gray-800">Profil Pengguna</h1>
        <?php if (isset($_SESSION['namalengkap'])): ?>
            <p class="text-center mt-2">Selamat datang <b><?= $_SESSION['namalengkap'] ?></b></p>
        <?php endif; ?>
    </div>
    <div class="flex justify-center items-center">
        <div class="bg-white w-full max-w-md p-8 rounded-lg shadow-lg mt-8">
            <?php if ($user): ?>
                <div class="mb-6 text-center">
                    <label for="profile_photo" class="block text-sm font-medium text-gray-700"></label>
                    <img src="./<?= $user['profile_photo'] ?>" alt="Foto Profil" class="rounded-full h-24 w-24 mx-auto shadow-lg">
                </div>
                <div class="mb-6">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username:</label>
                    <p id="username-display" class="text-lg font-semibold text-gray-800"><?= $user['username'] ?></p>
                </div>
                <div class="mb-6">
                    <label for="fullname" class="block text-sm font-medium text-gray-700">Nama Lengkap:</label>
                    <p id="fullname-display" class="text-lg font-semibold text-gray-800"><?= $user['namalengkap'] ?></p>
                </div>
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                    <p id="email-display" class="text-lg font-semibold text-gray-800"><?= $user['email'] ?></p>
                </div>
                <div class="mb-6">
                    <label for="address" class="block text-sm font-medium text-gray-700">Alamat:</label>
                    <p id="address-display" class="text-lg font-semibold text-gray-800"><?= $user['alamat'] ?></p>
                </div>
                <!-- Tampilkan jumlah foto yang sudah diunggah oleh pengguna -->
                <div class="mb-6">
                    <label for="total-photos" class="block text-sm font-medium text-gray-700">Jumlah Foto Diunggah:</label>
                    <p id="total-photos-display" class="text-lg font-semibold text-gray-800"><?= $total_photos ?></p>
                </div>
                <!-- Tombol Edit Profil -->
                <button id="edit-button" class="mt-4 w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Edit Profil</button>
                <!-- Popup Form Edit Profil -->
                <div class="popup-container" id="popup-container">
                    <div class="popup">
                        <h2 class="text-2xl font-bold mb-4">Edit Profil</h2>
                        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                            <div class="mb-4">
                                <label for="profile_photo" class="block text-sm font-medium text-gray-700">Upload Foto Profil:</label>
                                <input type="file" id="profile_photo" name="profile_photo" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                            </div>
                            <div class="mb-4">
                                <label for="username" class="block text-sm font-medium text-gray-700">Username:</label>
                                <input type="text" id="username" name="username" value="<?= $user['username'] ?>" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                            </div>
                            <div class="mb-4">
                                <label for="fullname" class="block text-sm font-medium text-gray-700">Nama Lengkap:</label>
                                <input type="text" id="fullname" name="fullname" value="<?= $user['namalengkap'] ?>" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                                <input type="email" id="email" name="email" value="<?= $user['email'] ?>" class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                            </div>
                            <div class="mb-4">
                                <label for="address" class="block text-sm font-medium text-gray-700">Alamat:</label>
                                <textarea id="address" name="address" class="mt-1 p-2 block w-full border border-gray-300 rounded-md"><?= $user['alamat'] ?></textarea>
                            </div>
                            <button type="submit" class="w-full bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600">Simpan Perubahan</button>
                        </form>
                        <button id="close-popup" class="mt-4 w-full bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600">Tutup</button>
                    </div>
                </div>
                <script>
                    // Tambahkan skrip untuk menampilkan/menyembunyikan popup
                    document.getElementById('edit-button').addEventListener('click', function () {
                        document.getElementById('popup-container').style.display = 'flex';
                    });

                    document.getElementById('close-popup').addEventListener('click', function () {
                        document.getElementById('popup-container').style.display = 'none';
                    });
                </script>
            <?php else: ?>
                <p class="text-center">Silakan <a href="login.php" class="text-blue-500 hover:underline">login</a> untuk mengakses profil Anda.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

