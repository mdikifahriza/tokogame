<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_admin'])) {
    die("Session id_admin tidak ditemukan.");
}

$id_admin = $_SESSION['id_admin'];
$admin_sql = "SELECT * FROM admin WHERE id_admin = ?";
$admin_stmt = $conn->prepare($admin_sql);
$admin_stmt->bind_param("i", $id_admin);
$admin_stmt->execute();
$admin_result = $admin_stmt->get_result();
$admin = $admin_result->fetch_assoc();
$admin_stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_game = $_POST['nama_game'];
    $id_kategori = $_POST['id_kategori'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $foto = $_FILES['foto_game'];
    
    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!in_array($foto['type'], $allowed_types)) {
        $error = "Format file tidak valid. Gunakan JPG atau PNG.";
    } elseif ($foto['size'] > 2000000) {
        $error = "Ukuran file terlalu besar. Maksimum 2MB.";
    } else {
        $foto_name = uniqid() . '_' . basename($foto['name']);
        $target_dir = "img/game/";
        $target_file = $target_dir . $foto_name;
        
        if (move_uploaded_file($foto['tmp_name'], $target_file)) {
            $sql = "INSERT INTO game (nama_game, id_kategori, deskripsi, harga, foto_game) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdis", $nama_game, $id_kategori, $deskripsi, $harga, $foto_name);

            if ($stmt->execute()) {
                echo "<script>
                    alert('Game berhasil ditambahkan!');
                        window.location.href = 'rubahgame.php';
                </script>";
                exit;
            } else {
                $error = "Gagal menambahkan game. Silakan coba lagi.";
            }

            $stmt->close();
        } else {
            $error = "Gagal mengupload foto.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Game Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }
        .sidebar {
            min-height: 100vh;
            height: auto;
            background-color: #6c757d;
            padding-top: 20px;
            box-shadow: 4px 0 6px rgba(0, 0, 0, 0.1);
        }
        .sidebar a {
            color: #ffffff;
            display: block;
            padding: 15px 20px;
            text-decoration: none;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        .sidebar a:hover {
            background-color: #495057;
            border-radius: 5px;
        }
        .sidebar img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 3px solid #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }
        .sidebar h4 {
            color: #ffffff;
            margin-top: 10px;
        }
        .dashboard-content {
            padding: 40px;
            flex-grow: 1;
        }
        .dashboard-content h3 {
            color: #343a40;
            margin-bottom: 30px;
            border-bottom: 2px solid #6c757d;
            padding-bottom: 10px;
        }
        .form-control {
            background-color: #ffffff;
            border: 1px solid #ced4da;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #6c757d;
            border: none;
        }
        .btn-primary:hover {
            background-color: #495057;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column align-items-center">
            <img src="img/admin/<?php echo htmlspecialchars($admin['foto_admin']); ?>" alt="Foto Admin">
            <h4 class="mt-2"><?php echo htmlspecialchars($admin['nama_admin']); ?></h4>
            <a href="rubahgame.php">Data Game</a>
            <a href="rubahkategori.php">Data Kategori</a>
            <a href="logout.php">Log Out</a>
        </div>

        <!-- Content -->
        <div class="dashboard-content flex-grow-1">
            <h3>Tambah Game Baru</h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama_game" class="form-label">Nama Game</label>
                    <input type="text" class="form-control" id="nama_game" name="nama_game" required>
                </div>
                <div class="mb-3">
                    <label for="id_kategori" class="form-label">Kategori</label>
                    <select class="form-control" id="id_kategori" name="id_kategori" required>
                        <?php
                        $kategori_sql = "SELECT * FROM kategori";
                        $kategori_result = $conn->query($kategori_sql);
                        while ($kategori = $kategori_result->fetch_assoc()) {
                            echo "<option value='{$kategori['id_kategori']}'>{$kategori['nama_kategori']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <input type="text" class="form-control" id="deskripsi" name="deskripsi" required>
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" required>
                </div>
                <div class="mb-3">
                    <label for="foto_game" class="form-label">Foto Game</label>
                    <input type="file" class="form-control" id="foto_game" name="foto_game" accept="img/game/" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Game</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
