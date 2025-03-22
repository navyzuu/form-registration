<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-6">Registrasi Pengguna</h1>
        
        <?php
        if (isset($_GET['error'])) {
            echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 
            rounded relative mb-4" role="alert">';
            echo '<span class="block sm:inline">' . htmlspecialchars($_GET['error']) . '</span>';
            echo '</div>';
        }
        
        if (isset($_GET['success'])) {
            echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 
            rounded relative mb-4" role="alert">';
            echo '<span class="block sm:inline">Registrasi berhasil!</span>';
            echo '</div>';
        }
        ?>
        
        <form action="process_register.php" method="post" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="nama" name="nama" required 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none 
                    focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="text" id="email" name="email"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none 
                    focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none 
                    focus:ring-indigo-500 focus:border-indigo-500">
                <p class="text-xs text-gray-500 mt-1">Password minimal 6 karakter</p>
            </div>
            
            <div>
                <label for="profile_image" class="block text-sm font-medium text-gray-700">Foto Profil</label>
                <input type="file" id="profile_image" name="profile_image" accept="image/*" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none 
                    focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            
            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md 
                shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 
                focus:ring-offset-2 focus:ring-indigo-500">
                    Daftar
                </button>
            </div>
        </form>
        
        <div class="text-center mt-4">
            <a href="list_user.php" class="text-indigo-600
        </div> hover:text-indigo-500">Lihat Pengguna Terdaftar</a>
    </div>
</body>
</html>