<?php 
session_start();
include "koneksi.php";

// Validasi sesi
if (!isset($_SESSION['id_admin'])) {
    die("Session id_admin tidak ditemukan.");
}

// Gunakan prepared statement untuk mendapatkan data admin
$id_admin = $_SESSION['id_admin'];
$admin_sql = "SELECT * FROM admin WHERE id_admin = ?";
$admin_stmt = $conn->prepare($admin_sql);
$admin_stmt->bind_param("i", $id_admin);
$admin_stmt->execute();
$admin_result = $admin_stmt->get_result();
$admin = $admin_result->fetch_assoc();
$admin_stmt->close();

// Ambil data kategori
$kategori_sql = "SELECT * FROM kategori";
$kategori_result = $conn->query($kategori_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS Styling */
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
        .product-table {
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        .product-table th {
            background-color: #6c757d;
            color: #ffffff;
            text-align: center;
        }
        .product-table td {
            text-align: center;
        }
        .product-table img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
        }
        .modal-body img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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
            <h3>Data Skincare</h3>
            <div class="table-responsive">
                <table class="table table-bordered product-table">
                    <thead>
                        <tr>
                            <th>ID Kategori</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($kategori = $kategori_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($kategori['id_kategori']); ?></td>
                            <td><?php echo htmlspecialchars($kategori['nama_kategori']); ?></td>
                            <td>
                                <a href="editkategori.php?id_kategori=<?php echo $kategori['id_kategori']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <button class="btn btn-danger btn-sm" onclick="deleteCategory(<?php echo $kategori['id_kategori']; ?>)">Hapus</button>
                            </td>
                        </tr>

                        <!-- Modal for enlarging image -->
                        <div class="modal fade" id="modal<?php echo $kategori['id_kategori']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Foto kategori: <?php echo htmlspecialchars($kategori['nama']); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="img/kategori/<?php echo htmlspecialchars($kategori['foto']); ?>" alt="Foto kategori">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <a href="tambahkategori.php" class="btn btn-primary">Tambah kategori</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Fungsi untuk menghapus kategori dengan AJAX
    function deleteCategory(id_kategori) {
        if (confirm("Apakah Anda yakin ingin menghapus kategori ini? Semua game yang terkait juga akan dihapus!")) {
            $.ajax({
                url: 'hapuskategori.php', // File PHP untuk memproses penghapusan
                type: 'POST',
                data: { id_kategori: id_kategori },
                success: function(response) {
                    const result = JSON.parse(response);
                    if (result.success) {
                        alert("Kategori berhasil dihapus.");
                        location.reload(); // Reload halaman setelah penghapusan berhasil
                    } else {
                        alert("Gagal menghapus kategori: " + result.message);
                    }
                },
                error: function() {
                    alert("Terjadi kesalahan saat menghapus kategori.");
                }
            });
        }
    }
</script>
</body>
</html>