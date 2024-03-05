<?php

include './koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil email dari query string
    $email = $_GET['email'];

    // Ambil password baru dan konfirmasi password dari form
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Periksa apakah password dan konfirmasi password cocok
    if ($new_password === $confirm_password) {
        // Update password baru ke dalam database
        $sql = "UPDATE user SET password='$new_password' WHERE email='$email'";

        if ($conn->query($sql) === TRUE) {
            // Redirect pengguna ke halaman login atau halaman lainnya setelah berhasil mengatur password baru
            header('location: ./login.php');
        } else {
            // Tampilkan pesan kesalahan jika gagal mengupdate password
            echo "Gagal mengupdate password";
        }
    } else {
        // Password dan konfirmasi password tidak cocok
        echo "Password dan konfirmasi password tidak cocok";
    }
}


?>

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap');

        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body>
    <div class="flex items-center justify-center h-screen">
        <div class="w-full max-w-md">
            <h1 class="text-4xl font-bold text-center mb-8">Reset Password</h1>
            <form action="" method="post">
                <div class="mb-4">
                    <label for="new_password" class="block text-gray-700 font-bold mb-2">New Password</label>
                    <input type="password" name="new_password" id="new_password"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded-md py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        required>
                    <label for="confirm_password" class="block text-gray-700 font-bold mb-2">Confirm New Password</label>
                    <input type="password" name="confirm_password" id="confirm_password"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded-md py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        required>
                </div>
                <div class="flex items-center justify-between mb-4">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
                    <a href="login.php" class="text-blue-500 hover:underline">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>