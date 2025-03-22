<?php
require_once 'config.php';

// Query untuk mendapatkan semua pengguna
$sql = "SELECT id, nama, email, profile_image, created_at FROM users ORDER BY id ASC";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengguna</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Daftar Pengguna Terdaftar</h1>
            <a href="index.php" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Tambah Pengguna</a>
        </div>
        
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>" . $row['id'] . "</td>";
                            echo "<td class='px-2 py-4'>";
                            
                            if (!empty($row['profile_image']) && file_exists($row['profile_image'])) {
                                // Tampilkan foto profil dengan ukuran yang proporsional
                                echo "<a href='" . $row['profile_image'] . "' target='_blank'>";
                                echo "<img src='" . $row['profile_image'] . "' alt='Profile'    
                                class='w-24 h-24     object-cover rounded-full border 
                                border-gray-300 shadow-md'>";
                                echo "</a>";
                            } else {
                                echo "<div class='w-full aspect-square bg-gray-300 flex items-center 
                                justify-center text-2xl rounded-lg'><span>" . substr($row['nama'], 0, 1) . 
                                "</span></div>";
                            }
                            
                            echo "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['nama']) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>" . date('d-m-Y H:i', strtotime($row['created_at'])) . 
                            "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='px-6 py-4 text-center'>Belum ada pengguna terdaftar</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php mysqli_close($con); ?>