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

if (!isset($_GET['id_game'])) {
    die("ID Game tidak ditemukan.");
}

$id_game = $_GET['id_game'];
$game_sql = "SELECT * FROM game WHERE id_game = ?";
$game_stmt = $conn->prepare($game_sql);
$game_stmt->bind_param("i", $id_game);
$game_stmt->execute();
$game_result = $game_stmt->get_result();
$game = $game_result->fetch_assoc();
$game_stmt->close();

if (!$game) {
    die("Game tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input POST
    $nama_game = trim($_POST['nama_game']);
    $id_kategori = (int) $_POST['id_kategori'];
    $deskripsi = trim($_POST['deskripsi']);
    $harga = (float) $_POST['harga'];
    $beli = (int) $_POST['beli'];
    $view = (int) $_POST['view'];
    
    if (empty($nama_game) || empty($deskripsi)) {
        $error = "Nama game dan deskripsi tidak boleh kosong.";
    } elseif ($harga <= 0) {
        $error = "Harga harus lebih besar dari 0.";
    }

    // Menangani file upload
    $foto_lama = $game['foto_game'];
    if (isset($_FILES['foto_game']) && $_FILES['foto_game']['error'] === UPLOAD_ERR_OK) {
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
                // Hapus foto lama jika ada
                if (file_exists($target_dir . $foto_lama)) {
                    unlink($target_dir . $foto_lama);
                }

                $foto_lama = $foto_name;
            } else {
                $error = "Gagal mengupload foto baru.";
            }
        }
    }

    if (!isset($error)) {
        // Update database
        $update_sql = "UPDATE game SET nama_game = ?, id_kategori = ?, deskripsi = ?, harga = ?, foto_game = ?, beli = ?, view = ? WHERE id_game = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sisdsdii", $nama_game, $id_kategori, $deskripsi, $harga, $foto_lama, $beli, $view, $id_game);

        if ($update_stmt->execute()) {
            echo "<script>
                alert('Game berhasil diubah!');
                window.location.href = 'rubahgame.php';
            </script>";
            exit;
        } else {
            $error = "Gagal mengubah game. Silakan coba lagi.";
        }

        $update_stmt->close();
    }

    // Menampilkan pesan error jika ada
    if (isset($error)) {
        echo "<script>alert('$error');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Game</title>
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
            <h3>Edit Game</h3>
            <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama_game" class="form-label">Nama Game</label>
                    <input type="text" class="form-control" id="nama_game" name="nama_game" value="<?php echo htmlspecialchars($game['nama_game']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="id_kategori" class="form-label">Kategori</label>
                    <select class="form-control" id="id_kategori" name="id_kategori" required>
                        <?php
                        $kategori_sql = "SELECT * FROM kategori";
                        $kategori_result = $conn->query($kategori_sql);
                        while ($kategori = $kategori_result->fetch_assoc()) {
                            $selected = $game['id_kategori'] == $kategori['id_kategori'] ? "selected" : "";
                            echo "<option value='{$kategori['id_kategori']}' $selected>{$kategori['nama_kategori']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="<?php echo htmlspecialchars($game['deskripsi']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" value="<?php echo htmlspecialchars($game['harga']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="foto_game" class="form-label">Foto Game</label>
                    <input type="file" class="form-control" id="foto_game" name="foto_game" accept="image/*">
                </div>
                <div class="mb-3">
                    <label for="beli" class="form-label">Beli</label>
                    <input type="number" class="form-control" id="beli" name="beli" value="<?php echo htmlspecialchars($game['beli']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="view" class="form-label">View</label>
                    <input type="number" class="form-control" id="view" name="view" value="<?php echo htmlspecialchars($game['view']); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
