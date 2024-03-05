<?php

include 'koneksi.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil kode reset dari form
    $reset_code = $_POST['reset_code'];

    // Ambil email yang terkait dengan kode reset
    $email = $_POST['email'];

    // Cek apakah kode reset yang dimasukkan oleh pengguna sesuai dengan yang tersimpan di database
    $sql = "SELECT * FROM reset_password WHERE email='$email' AND reset_code='$reset_code'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Jika kode reset cocok, arahkan pengguna ke halaman untuk mengatur password baru
        header('location: set_new_password.php?email=' . $email);
    } else {
        // Jika kode reset tidak cocok, tampilkan pesan kesalahan
        $_SESSION['wrong'] = "Reset Code salah, Coba masukkan lagi";
        header('location: reset_password.php?email=' . urlencode($email));
        exit();
    }
}

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
                <input type="hidden" name="email" value="<?= $_GET['email'] ?>">
                <div class="mb-4">
                    <label for="reset_code" class="block text-gray-700 font-bold mb-2">Masukkan Kode</label>
                    <input type="reset_code" name="reset_code" id="reset_code"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded-md py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        required>
                </div>
                <div class="flex items-center justify-between mb-4">
                    <button type="submit" name="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
                    <a href="login.php" class="text-blue-500 hover:underline">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>