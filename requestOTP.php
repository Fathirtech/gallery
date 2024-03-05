<?php

include './koneksi.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendResetPasswordEmail($email, $reset_code)
{
    // Kirim email menggunakan PHPMailer

    $mail = new PHPMailer(true);

    try {
        // Konfigurasi SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'abdoelfathir733@gmail.com';
        $mail->Password = 'kktlvyhtasomhanf';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Siapkan email
        $mail->setFrom('abdoelfathir733@gmail.com', 'admin');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Reset Your Password';
        $mail->Body = 'Code Verifikasi Password : ' . $reset_code;

        // Kirim email
        $mail->send();

        return true; // Email berhasil dikirim
    } catch (Exception $e) {
        // Email gagal dikirim, kembalikan false dan tampilkan pesan error
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil email dari form
    $email = $_POST['email'];

    // Periksa apakah email sudah ada di tabel user
    $check_email_query = "SELECT * FROM user WHERE email = '$email'";
    $check_email_result = $conn->query($check_email_query);

    if ($check_email_result->num_rows > 0) {
        // Email sudah ada di tabel user, lanjutkan proses reset password

        // Periksa apakah email sudah ada di tabel reset_password
        $check_reset_email_query = "SELECT * FROM reset_password WHERE email = '$email'";
        $check_reset_email_result = $conn->query($check_reset_email_query);

        if ($check_reset_email_result->num_rows > 0) {
            // Email sudah ada di tabel reset_password, update reset_code

            // Generate reset code
            $reset_code = '';

            // Menghasilkan 6 karakter acak
            for ($i = 0; $i < 6; $i++) {
                $reset_code .= rand(0, 9); // Menghasilkan angka acak dari 0 hingga 9
            }

            // Update reset code di database
            $update_reset_code_query = "UPDATE reset_password SET reset_code = '$reset_code' WHERE email = '$email'";
            if ($conn->query($update_reset_code_query) === TRUE) {
                // Kirim email menggunakan fungsi sendResetPasswordEmail
                if (sendResetPasswordEmail($email, $reset_code)) {
                    // Redirect ke halaman reset password dengan mengirim email sebagai parameter
                    header('location: ./reset_password.php?email=' . urlencode($email));
                    $_SESSION['success'] = "Code Reset Password sudah dikirim";
                } else {
                    // Jika gagal mengirim email, tampilkan pesan error
                    $error_message = "Failed to send reset password email.";
                }
            } else {
                // Redirect atau tampilkan pesan error
                echo "Error updating reset code: " . $conn->error;
            }
        } else {
            // Email belum ada di tabel reset_password, tambahkan data baru

            // Generate reset code
            $reset_code = '';

            // Menghasilkan 6 karakter acak
            for ($i = 0; $i < 6; $i++) {
                $reset_code .= rand(0, 9); // Menghasilkan angka acak dari 0 hingga 9
            }

            // Simpan reset code ke database
            $sql = "INSERT INTO reset_password (email, reset_code) VALUES ('$email', '$reset_code')";

            if ($conn->query($sql) === TRUE) {
                // Kirim email menggunakan fungsi sendResetPasswordEmail
                if (sendResetPasswordEmail($email, $reset_code)) {
                    // Redirect ke halaman reset password dengan mengirim email sebagai parameter
                    header('location: ./reset_password.php?email=' . urlencode($email));
                    $_SESSION['success'] = "Code Reset Password sudah dikirim";
                } else {
                    // Jika gagal mengirim email, tampilkan pesan error
                    $error_message = "Failed to send reset password email.";
                }
            } else {
                // Redirect atau tampilkan pesan error
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        // Email tidak terdaftar di tabel user
        $error_message = "Email ini tidak terdaftar.";
    }

    $conn->close();
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
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                    <input type="email" name="email" id="email"
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
