<?php
include('config.php');

// Cek jika ada proses registrasi yang berhasil, tampilkan halaman sukses
if (isset($_GET['show_success'])) {
    // Tampilkan halaman sukses dengan script redirect
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registrasi Berhasil</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            .loader {
                border: 5px solid #f3f3f3;
                border-top: 5px solid #3498db;
                border-radius: 50%;
                width: 50px;
                height: 50px;
                animation: spin 2s linear infinite;
                margin: 20px auto;
            }
            
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>
    </head>
    <body class="bg-gray-100 min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md text-center">
            <div class="text-green-500 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Registrasi Berhasil!</h2>
            <p class="text-gray-600 mb-6">Akun Anda telah berhasil ditambahkan.</p>
            
            <div class="loader"></div>
            
            <p class="text-gray-500 mt-4">Mengalihkan ke halaman beranda...</p>
        </div>
        
        <script>
            // Redirect setelah 3 detik
            setTimeout(function() {
                window.location.href = 'index.php?success=1';
            }, 3000);
        </script>
    </body>
    </html>
    <?php
    exit();
}

// Memeriksa jika form telah disubmit menggunakan POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($con, $_POST['nama']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];
    
    // Fungsi Validasi Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: index.php?error=Format email tidak valid");
        exit();
    }
    
    // Fungsi Validasi Password ketika karakter lebih dari sama dengan 6
    if (strlen($password) < 6) {
        header("Location: index.php?error=Password minimal harus 6 karakter");
        exit();
    }
    
    // Enkripsi password untuk keamanan lebih lanjut
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Upload foto profil
    $profile_image = "";
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = $_FILES['profile_image']['type'];
        
        if (!in_array($file_type, $allowed_types)) {
            header("Location: index.php?error=Jenis file tidak diizinkan. Hanya JPG, PNG, dan GIF yang diperbolehkan");
            exit();
        }
        
        $upload_dir = "uploads/";
        
        // Buat direktori jika belum ada
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_name = time() . '_' . basename($_FILES['profile_image']['name']);
        $target_path = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_path)) {
            $profile_image = $target_path;
        } else {
            header("Location: index.php?error=Terjadi kesalahan saat mengupload file");
            exit();
        }
    } else {
        header("Location: index.php?error=Foto profil wajib diupload");
        exit();
    }
    
    // Periksa apakah email sudah terdaftar
    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $check_email);
    
    if (mysqli_num_rows($result) > 0) {
        header("Location: index.php?error=Email sudah terdaftar, gunakan email lain");
        exit();
    }
    
    // Simpan data ke database
    $sql = "INSERT INTO users (nama, email, password, profile_image) 
            VALUES ('$nama', '$email', '$hashed_password', '$profile_image')";
    
    if (mysqli_query($con, $sql)) {
        // Alihkan ke halaman sukses dengan efek loading
        header("Location: process_register.php?show_success=1");
    } else {
        header("Location: index.php?error=Terjadi kesalahan: " . mysqli_error($con));
    }
    
    mysqli_close($con);
} else {
    // Jika form tidak disubmit dengan POST, redirect ke halaman registrasi
    header("Location: index.php");
}
?>