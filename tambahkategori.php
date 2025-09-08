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
    $nama_kategori = $_POST['nama_kategori'];

    $insert_sql = "INSERT INTO kategori (nama_kategori) VALUES (?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("s", $nama_kategori);

    if ($insert_stmt->execute()) {
        header("Location: rubahkategori.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }

    $insert_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Kategori Baru</title>
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
            <h3>Tambah Kategori Baru</h3>
            <form method="POST">
                <div class="mb-3">
                    <label for="nama_kategori" class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Kategori</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
